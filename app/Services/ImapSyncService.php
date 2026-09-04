<?php

namespace App\Services;

use App\Models\Message;
use Exception;
use Illuminate\Support\Facades\Log;

class ImapSyncService
{
    protected string $host = 'ssl://imap.gmail.com';
    protected int $port = 993;

    /**
     * Synchronize reply emails directly from Gmail IMAP into the database.
     * High-Performance Header-First Strategy optimized for Free Hosting (42web.io).
     *
     * @return array{status: string, synced_count: int, message: string}
     */
    public function syncInbox(): array
    {
        $username = config('mail.mailers.smtp.username') ?? env('MAIL_USERNAME');
        $password = config('mail.mailers.smtp.password') ?? env('MAIL_PASSWORD');

        if (empty($username) || empty($password)) {
            return [
                'status' => 'error',
                'synced_count' => 0,
                'message' => 'Gmail SMTP credentials missing in configuration.',
            ];
        }

        $socket = @fsockopen($this->host, $this->port, $errno, $errstr, 10);
        if (!$socket) {
            return [
                'status' => 'error',
                'synced_count' => 0,
                'message' => "Failed to connect to Gmail IMAP: {$errstr} ({$errno})",
            ];
        }

        // Read initial greeting
        fgets($socket);

        // 1. Authenticate
        $loginCmd = "A001 LOGIN " . $this->escapeImapString($username) . " " . $this->escapeImapString($password) . "\r\n";
        fputs($socket, $loginCmd);

        if (!$this->isCommandSuccess($socket, 'A001')) {
            fclose($socket);
            return [
                'status' => 'error',
                'synced_count' => 0,
                'message' => 'Gmail IMAP authentication failed. Please check App Password.',
            ];
        }

        // 2. Select INBOX
        fputs($socket, "A002 SELECT INBOX\r\n");
        if (!$this->isCommandSuccess($socket, 'A002')) {
            fclose($socket);
            return [
                'status' => 'error',
                'synced_count' => 0,
                'message' => 'Failed to select Gmail INBOX.',
            ];
        }

        // 3. Search for recent messages in Gmail INBOX
        fputs($socket, "A003 SEARCH ALL\r\n");
        $searchLines = $this->readCommandOutput($socket, 'A003');
        
        $msgNumbers = [];
        foreach ($searchLines as $line) {
            if (str_starts_with($line, '* SEARCH')) {
                $parts = explode(' ', trim($line));
                array_shift($parts); // remove '*'
                array_shift($parts); // remove 'SEARCH'
                $msgNumbers = array_filter(array_map('intval', $parts));
            }
        }

        if (empty($msgNumbers)) {
            fputs($socket, "A004 LOGOUT\r\n");
            fclose($socket);
            return [
                'status' => 'success',
                'synced_count' => 0,
                'message' => 'No messages found in Gmail inbox.',
            ];
        }

        // Inspect last 10 messages for lightning-fast execution (<1s) on free web hosting
        if (count($msgNumbers) > 10) {
            $msgNumbers = array_slice($msgNumbers, -10);
        }

        $syncedCount = 0;

        // 4. Header-First Stream Parsing
        foreach ($msgNumbers as $seqNo) {
            // Fetch HEADER first (super lightweight & fast)
            fputs($socket, "H{$seqNo} FETCH {$seqNo} (BODY[HEADER.FIELDS (FROM SUBJECT DATE)])\r\n");
            $headerOutput = implode("\n", $this->readCommandOutput($socket, "H{$seqNo}"));

            $fromHeader = $this->extractHeaderValue($headerOutput, 'From');
            $subject = $this->extractHeaderValue($headerOutput, 'Subject') ?: 'Re: Portfolio Inquiry';

            if (empty($fromHeader)) {
                continue;
            }

            preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $fromHeader, $matches);
            $cleanEmail = strtolower($matches[0] ?? $fromHeader);

            // Skip self-sent emails from your own account
            if ($cleanEmail === strtolower($username)) {
                continue;
            }

            // Fetch full email BODY[] stream only for valid candidate emails
            fputs($socket, "B{$seqNo} FETCH {$seqNo} (BODY[])\r\n");
            $rawEmail = implode("\n", $this->readCommandOutput($socket, "B{$seqNo}"));
            $body = $this->extractBodyContent($rawEmail);

            if (empty($body)) {
                continue;
            }

            // Find thread in DB
            $existingMessage = Message::where('sender_email', $cleanEmail)->latest()->first();

            if ($existingMessage) {
                $replies = $existingMessage->replies ?? [];
                
                if (empty($replies) && !empty($existingMessage->reply_body)) {
                    $replies[] = [
                        'body' => $existingMessage->reply_body,
                        'created_at' => $existingMessage->replied_at ? $existingMessage->replied_at->toIso8601String() : now()->toIso8601String(),
                        'sender' => 'admin',
                    ];
                }

                // Check if this reply is already recorded to avoid duplicates
                $alreadyExists = false;
                foreach ($replies as $r) {
                    if (trim($r['body']) === trim($body)) {
                        $alreadyExists = true;
                        break;
                    }
                }

                if (!$alreadyExists) {
                    $replies[] = [
                        'body' => $body,
                        'created_at' => now()->toIso8601String(),
                        'sender' => 'client',
                    ];

                    $existingMessage->update([
                        'replies' => $replies,
                        'is_read' => false,
                        'replied_at' => now(),
                    ]);

                    $syncedCount++;
                }
            } else {
                $senderName = trim(explode('<', $fromHeader)[0]);
                $senderName = trim($senderName, ' "\'');
                if (empty($senderName) || str_contains($senderName, '@')) {
                    $senderName = explode('@', $cleanEmail)[0];
                }

                Message::create([
                    'sender_name' => ucwords($senderName),
                    'sender_email' => $cleanEmail,
                    'subject' => $subject,
                    'body' => $body,
                    'is_read' => false,
                ]);

                $syncedCount++;
            }
        }

        // 5. Clean legacy base64 strings in existing database records
        $this->sanitizeExistingMessages();

        fputs($socket, "A005 LOGOUT\r\n");
        fclose($socket);

        return [
            'status' => 'success',
            'synced_count' => $syncedCount,
            'message' => $syncedCount > 0 
                ? "Successfully synchronized {$syncedCount} email reply(ies) into your dashboard."
                : "Inbox is up to date.",
        ];
    }

    private function sanitizeExistingMessages(): void
    {
        $messages = Message::all();
        foreach ($messages as $msg) {
            $cleaned = $this->decodeIfBase64($msg->body);
            if ($cleaned !== $msg->body) {
                $msg->update(['body' => $cleaned]);
            }
        }
    }

    private function decodeIfBase64(string $text): string
    {
        $trimmed = trim($text);
        if (empty($trimmed)) return '';

        if (!str_contains($trimmed, ' ') && strlen($trimmed) > 20 && preg_match('/^[a-zA-Z0-9+\/=\r\n]+$/', $trimmed)) {
            $decoded = base64_decode(preg_replace('/\s+/', '', $trimmed));
            if ($decoded && preg_match('/[a-zA-Z0-9]/', $decoded)) {
                return trim(strip_tags($decoded));
            }
        }

        return $trimmed;
    }

    private function escapeImapString(string $str): string
    {
        return '"' . addslashes($str) . '"';
    }

    private function isCommandSuccess($socket, string $tag): bool
    {
        while ($line = fgets($socket)) {
            if (str_starts_with($line, "{$tag} OK")) {
                return true;
            }
            if (str_starts_with($line, "{$tag} NO") || str_starts_with($line, "{$tag} BAD")) {
                return false;
            }
        }
        return false;
    }

    private function readCommandOutput($socket, string $tag): array
    {
        $lines = [];
        while ($line = fgets($socket)) {
            $lines[] = rtrim($line, "\r\n");
            if (str_starts_with($line, "{$tag} OK") || str_starts_with($line, "{$tag} NO") || str_starts_with($line, "{$tag} BAD")) {
                break;
            }
        }
        return $lines;
    }

    private function extractHeaderValue(string $rawEmail, string $headerName): string
    {
        if (preg_match('/^' . preg_quote($headerName, '/') . ':\s*(.+)$/mi', $rawEmail, $matches)) {
            return trim($matches[1]);
        }
        return '';
    }

    private function extractBodyContent(string $rawEmail): string
    {
        // Extract text/plain or text/html part from MIME body
        if (preg_match('#Content-Type:\s*text/plain.*?\r?\n\r?\n(.*?)(?=\r?\n--|\r?\n\r?\n|$)#si', $rawEmail, $m)) {
            $body = $m[1];
        } elseif (preg_match('#Content-Type:\s*text/html.*?\r?\n\r?\n(.*?)(?=\r?\n--|\r?\n\r?\n|$)#si', $rawEmail, $m)) {
            $body = strip_tags($m[1]);
        } else {
            $parts = preg_split('/\r?\n\r?\n/', $rawEmail, 2);
            $body = $parts[1] ?? $rawEmail;
        }

        // Decode Base64 if encoded
        if (preg_match('/Content-Transfer-Encoding:\s*base64/i', $rawEmail)) {
            $decoded = base64_decode(preg_replace('/\s+/', '', $body));
            if ($decoded) {
                $body = $decoded;
            }
        } elseif (preg_match('/Content-Transfer-Encoding:\s*quoted-printable/i', $rawEmail)) {
            $body = quoted_printable_decode($body);
        }

        $clean = trim(strip_tags($body));

        // Trim "On ... wrote:" quotes
        if (preg_match('/^(.*?)(?:On\s+.*wrote:)/si', $clean, $qm)) {
            if (!empty(trim($qm[1]))) {
                $clean = trim($qm[1]);
            }
        }

        // Ensure clean UTF-8 string encoding for JSON database storage
        if (!mb_check_encoding($clean, 'UTF-8')) {
            $clean = mb_convert_encoding($clean, 'UTF-8', 'UTF-8');
        }

        return $clean;
    }
}
