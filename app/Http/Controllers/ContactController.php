<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function __invoke(ContactRequest $request, ContactService $contactService): RedirectResponse
    {
        $contactService->storeInquiry($request->validated());

        return redirect()->back()->with('success', 'Thank you for reaching out! Your message has been received.');
    }
}
