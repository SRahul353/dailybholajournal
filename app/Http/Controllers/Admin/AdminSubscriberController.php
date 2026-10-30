<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class AdminSubscriberController extends Controller
{
    /**
     * Display a listing of newsletter subscribers.
     */
    public function index(Request $request)
    {
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
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')->with('success', 'সাবস্ক্রাইবার সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
