<?php

namespace App\Services;

use App\Models\Message;
use App\Mail\InquiryReplyMail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class MessageService
{
    public function getAllMessages(): Collection
    {
        return Message::latest()->get();
    }

    public function toggleReadStatus(Message $message): bool
    {
        return $message->update(['is_read' => !$message->is_read]);
    }

    public function sendReply(Message $message, string $replyMessage): bool
    {
        // 1. Send Email via Mailer (Gmail SMTP)
        Mail::to($message->sender_email)->send(new InquiryReplyMail($message, $replyMessage));

        // 2. Append reply to multi-reply history array
        $replies = $message->replies ?? [];

        // If replies array is empty but single reply_body exists, include legacy reply
        if (empty($replies) && !empty($message->reply_body)) {
            $replies[] = [
                'body' => $message->reply_body,
                'created_at' => $message->replied_at ? $message->replied_at->toIso8601String() : now()->toIso8601String(),
            ];
        }

        $replies[] = [
            'body' => $replyMessage,
            'created_at' => now()->toIso8601String(),
        ];

        // 3. Save to database
        return $message->update([
            'is_read' => true,
            'replied_at' => now(),
            'reply_body' => $replyMessage,
            'replies' => $replies,
        ]);
    }

    public function deleteMessage(Message $message): bool
    {
        return $message->delete();
    }
}
