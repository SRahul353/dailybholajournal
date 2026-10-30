<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminContactMessageController extends Controller
{
    /**
     * Display a listing of contact form submissions.
     */
    public function index(Request $request)
    {
        Gate::authorize('admin-or-super');
        $search = $request->query('search', '');
        $status = $request->query('status', 'all');

        $query = ContactMessage::latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($status === 'unread') {
            $query->where('is_read', false);
        } elseif ($status === 'read') {
            $query->where('is_read', true);
        }

        $messages = $query->paginate(20);
        $unreadCount = ContactMessage::unread()->count();

        return view('admin.messages.index', compact('messages', 'search', 'status', 'unreadCount'));
    }

    /**
     * Display the specified contact message and mark as read.
     */
    public function show($id)
    {
        Gate::authorize('admin-or-super');

        $message = ContactMessage::findOrFail($id);

        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Remove the specified contact message from storage.
     */
    public function destroy($id)
    {
        Gate::authorize('admin-or-super');

        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'বার্তাটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
