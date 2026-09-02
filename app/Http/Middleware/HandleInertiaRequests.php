<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Message;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'unreadInquiries' => fn () => $request->user() 
                ? Message::where('is_read', false)->latest()->take(6)->get(['id', 'sender_name', 'sender_email', 'subject', 'body', 'created_at'])
                : [],
            'unreadInquiriesCount' => fn () => $request->user() 
                ? Message::where('is_read', false)->count()
                : 0,
        ];
    }
}
