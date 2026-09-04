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
     * Synchronize unread reply emails directly from Gmail IMAP into the database.
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

        $socket = @fsockopen($this->host, $this->port, $errno, $errstr, 15);
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

        // Limit inspection to last 20 messages for fast response
        if (count($msgNumbers) > 20) {
            $msgNumbers = array_slice($msgNumbers, -20);
        }

        $syncedCount = 0;

        // 4. Process each email message
        foreach ($msgNumbers as $seqNo) {
            fputs($socket, "F{$seqNo} FETCH {$seqNo} (BODY[HEADER.FIELDS (FROM SUBJECT DATE)] BODY[TEXT])\r\n");
            $fetchOutput = implode("\n", $this->readCommandOutput($socket, "F{$seqNo}"));

            $fromEmail = $this->extractHeaderValue($fetchOutput, 'From');
            $subject = $this->extractHeaderValue($fetchOutput, 'Subject') ?: 'Re: Portfolio Inquiry';
            $body = $this->extractBodyContent($fetchOutput);

            if (empty($fromEmail) || empty($body)) {
                continue;
            }

            // Clean sender email (e.g., "John Doe <john@example.com>")
            preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $fromEmail, $matches);
            $cleanEmail = strtolower($matches[0] ?? $fromEmail);

            // Skip self-sent emails from your own mail account
            if ($cleanEmail === strtolower($username)) {
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
                $senderName = trim(explode('<', $fromEmail)[0]);
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

        // If string contains no spaces and matches base64 pattern
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

    private function extractHeaderValue(string $fetchOutput, string $headerName): string
    {
        if (preg_match('/' . preg_quote($headerName, '/') . ':\s*(.+)/i', $fetchOutput, $matches)) {
            return trim($matches[1]);
        }
        return '';
    }

    private function extractBodyContent(string $fetchOutput): string
    {
        // 1. Decode Base64 encoded email bodies if present
        if (preg_match('/Content-Transfer-Encoding:\s*base64/i', $fetchOutput)) {
            $parts = preg_split('/\r?\n\r?\n/', $fetchOutput, 2);
            $rawBody = $parts[1] ?? '';
            $rawBody = preg_replace('/--[a-zA-Z0-9_-]+.*/', '', $rawBody);
            $rawBody = preg_replace('/F\d+ OK.*/', '', $rawBody);
            $decoded = base64_decode(preg_replace('/\s+/', '', $rawBody));
            if (!empty(trim($decoded))) {
                return trim(strip_tags($decoded));
            }
        }

        // 2. Decode Quoted-Printable encoded email bodies if present
        if (preg_match('/Content-Transfer-Encoding:\s*quoted-printable/i', $fetchOutput)) {
            $parts = preg_split('/\r?\n\r?\n/', $fetchOutput, 2);
            $rawBody = $parts[1] ?? '';
            $rawBody = preg_replace('/--[a-zA-Z0-9_-]+.*/', '', $rawBody);
            $rawBody = preg_replace('/F\d+ OK.*/', '', $rawBody);
            $decoded = quoted_printable_decode(trim($rawBody));
            if (!empty(trim($decoded))) {
                return trim(strip_tags($decoded));
            }
        }

        // 3. Fallback to standard plain text extraction
        $parts = preg_split('/\r?\n\r?\n/', $fetchOutput, 2);
        $rawText = $parts[1] ?? $fetchOutput;

        // Remove IMAP completion tags if present
        $rawText = preg_replace('/F\d+ OK.*/', '', $rawText);
        $rawText = preg_replace('/\)\s*$/', '', $rawText);

        // Clean HTML tags if plain text wasn't returned
        $clean = trim(strip_tags($rawText));

        // Trim quotes / legacy quoted headers if present
        if (str_contains($clean, 'On ') && str_contains($clean, ' wrote:')) {
            $splitQuote = preg_split('/On\s+.*\s+wrote:/i', $clean);
            if (!empty(trim($splitQuote[0]))) {
                $clean = trim($splitQuote[0]);
            }
        }

        return $clean;
    }
}
