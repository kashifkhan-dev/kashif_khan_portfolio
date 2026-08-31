<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

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

    public function deleteMessage(Message $message): bool
    {
        return $message->delete();
    }
}
