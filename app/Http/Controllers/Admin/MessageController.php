<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Services\ImapSyncService;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MessageController extends Controller
{
    public function __construct(
        protected MessageService $messageService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Messages/Index', [
            'messages' => $this->messageService->getAllMessages(),
        ]);
    }

    public function sync(ImapSyncService $imapSyncService)
    {
        $result = $imapSyncService->syncInbox();

        if ($result['status'] === 'error') {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->back()->with('success', $result['message']);
    }

    public function toggleRead(Message $message)
    {
        $this->messageService->toggleReadStatus($message);

        return redirect()->back()->with('success', 'Message status updated.');
    }

    public function markAllRead()
    {
        $this->messageService->markAllAsRead();

        return redirect()->back()->with('success', 'All messages marked as read.');
    }

    public function reply(Request $request, Message $message)
    {
        $validated = $request->validate([
            'reply_body' => 'required|string|min:2',
        ]);

        $this->messageService->sendReply($message, $validated['reply_body']);

        return redirect()->back()->with('success', "Email reply successfully sent to {$message->sender_email}!");
    }

    public function destroy(Message $message)
    {
        $this->messageService->deleteMessage($message);

        return redirect()->back()->with('success', 'Message deleted successfully.');
    }
}
