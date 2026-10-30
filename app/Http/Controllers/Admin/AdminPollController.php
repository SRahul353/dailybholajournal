<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use Illuminate\Http\Request;

class AdminPollController extends Controller
{
    /**
     * Display a listing of online polls.
     */
    public function index()
    {
        $polls = Poll::withCount('votes')->latest()->paginate(15);

        return view('admin.polls.index', compact('polls'));
    }

    /**
     * Store a newly created poll.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'is_active' => 'nullable|boolean',
        ], [
            'question.required' => 'জরিপের প্রশ্ন প্রদান করুন।',
        ]);

        $isActive = $request->has('is_active');

        // If newly created poll is marked active, optionally deactivate other polls
        if ($isActive) {
            Poll::where('is_active', true)->update(['is_active' => false]);
        }

        Poll::create([
            'question' => $request->question,
            'is_active' => $isActive,
            'yes_votes' => 0,
            'no_votes' => 0,
            'neutral_votes' => 0,
        ]);

        return redirect()->route('admin.polls.index')->with('success', 'নতুন অনলাইন জরিপ সফলভাবে যুক্ত করা হয়েছে।');
    }

    /**
     * Toggle poll active/inactive status.
     */
    public function toggle($id)
    {
        $poll = Poll::findOrFail($id);
        
        if (!$poll->is_active) {
            // Deactivate all others so only 1 active poll runs at a time
            Poll::where('id', '!=', $poll->id)->update(['is_active' => false]);
            $poll->update(['is_active' => true]);
            $message = 'জরিপটি সক্রিয় করা হয়েছে।';
        } else {
            $poll->update(['is_active' => false]);
            $message = 'জরিপটি নিষ্ক্রিয় করা হয়েছে।';
        }

        return redirect()->route('admin.polls.index')->with('success', $message);
    }

    /**
     * Reset vote counts for a poll.
     */
    public function resetVotes($id)
    {
        $poll = Poll::findOrFail($id);
        
        $poll->update([
            'yes_votes' => 0,
            'no_votes' => 0,
            'neutral_votes' => 0,
        ]);

        $poll->votes()->delete();

        return redirect()->route('admin.polls.index')->with('success', 'জরিপের সকল ভোট শূন্যে রিসেট করা হয়েছে।');
    }

    /**
     * Remove the poll from database.
     */
    public function destroy($id)
    {
        $poll = Poll::findOrFail($id);
        $poll->votes()->delete();
        $poll->delete();

        return redirect()->route('admin.polls.index')->with('success', 'জরিপটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
