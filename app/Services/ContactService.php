<?php

namespace App\Services;

use App\Models\Message;

class ContactService
{
    public function storeInquiry(array $data): Message
    {
        return Message::create($data);
    }
}
