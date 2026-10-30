<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminSubscriberController extends Controller
{
    /**
     * Display a listing of newsletter subscribers.
     */
    public function index(Request $request)
    {
        Gate::authorize('admin-or-super');
        $search = $request->query('search', '');

        $query = Subscriber::latest();

        if (!empty($search)) {
            $query->where('email', 'like', "%{$search}%");
        }

        $subscribers = $query->paginate(20);
        $totalSubscribers = Subscriber::count();

        return view('admin.subscribers.index', compact('subscribers', 'search', 'totalSubscribers'));
    }

    /**
     * Remove the specified subscriber from storage.
     */
    public function destroy($id)
    {
        Gate::authorize('admin-or-super');

        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')->with('success', 'সাবস্ক্রাইবার সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
