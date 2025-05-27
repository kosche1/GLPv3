<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('support-tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('technical-support');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'category' => ['required', Rule::in([
                'technical_issue',
                'account_problem',
                'billing_question',
                'course_access',
                'feature_request',
                'other'
            ])],
            'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
            'attachments.*' => 'nullable|file|max:10240|mimes:png,jpg,jpeg,gif,pdf,doc,docx',
            'notify_on_update' => 'nullable|boolean',
        ]);

        // Handle file uploads
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support-tickets', 'public');
                $attachments[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ];
            }
        }

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'attachments' => $attachments,
            'notify_on_update' => $request->boolean('notify_on_update'),
        ]);

        return redirect()->route('technical-support')
            ->with('success', "Your support ticket #{$ticket->ticket_number} has been submitted successfully! We'll get back to you soon.");
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket)
    {
        // Ensure user can only view their own tickets
        if ($supportTicket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this ticket.');
        }

        return view('support-tickets.show', compact('supportTicket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportTicket $supportTicket)
    {
        // Ensure user can only edit their own tickets and only if they're open
        if ($supportTicket->user_id !== Auth::id() || $supportTicket->status !== 'open') {
            abort(403, 'You cannot edit this ticket.');
        }

        return view('support-tickets.edit', compact('supportTicket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupportTicket $supportTicket)
    {
        // Ensure user can only update their own tickets and only if they're open
        if ($supportTicket->user_id !== Auth::id() || $supportTicket->status !== 'open') {
            abort(403, 'You cannot update this ticket.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'category' => ['required', Rule::in([
                'technical_issue',
                'account_problem',
                'billing_question',
                'course_access',
                'feature_request',
                'other'
            ])],
            'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
            'notify_on_update' => 'nullable|boolean',
        ]);

        $supportTicket->update([
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'notify_on_update' => $request->boolean('notify_on_update'),
        ]);

        return redirect()->route('support-tickets.show', $supportTicket)
            ->with('success', 'Your ticket has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportTicket $supportTicket)
    {
        // Ensure user can only delete their own tickets and only if they're open
        if ($supportTicket->user_id !== Auth::id() || $supportTicket->status !== 'open') {
            abort(403, 'You cannot delete this ticket.');
        }

        // Delete associated files
        if ($supportTicket->attachments) {
            foreach ($supportTicket->attachments as $attachment) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        $supportTicket->delete();

        return redirect()->route('support-tickets.index')
            ->with('success', 'Your ticket has been deleted successfully.');
    }

    /**
     * Download attachment file.
     */
    public function downloadAttachment(SupportTicket $supportTicket, $attachmentIndex)
    {
        // Ensure user can only download attachments from their own tickets
        if ($supportTicket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this attachment.');
        }

        if (!isset($supportTicket->attachments[$attachmentIndex])) {
            abort(404, 'Attachment not found.');
        }

        $attachment = $supportTicket->attachments[$attachmentIndex];
        $filePath = storage_path('app/public/' . $attachment['path']);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $attachment['original_name']);
    }
}
