<?php

namespace App\Http\Controllers;

use App\Models\OpinionSubmission;
use Illuminate\Http\Request;

class OpinionController extends Controller
{
    /**
     * Show the public opinion and column submission form.
     */
    public function create()
    {
        return view('opinions.submit');
    }

    /**
     * Store the submitted opinion or column.
     */
    public function store(Request $request)
    {
        $request->validate([
            'author_name' => 'required|string|max:150',
            'author_email' => 'required|email|max:150',
            'author_phone' => 'required|string|max:30',
            'author_designation' => 'required|string|max:150',
            'author_bio' => 'nullable|string|max:600',
            'author_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'title' => 'required|string|max:255|min:10',
            'topic' => 'nullable|string|max:100',
            'content' => 'required|string|min:150',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'agreement' => 'accepted',
        ], [
            'author_name.required' => 'আপনার পূর্ণ নাম প্রদান করুন।',
            'author_email.required' => 'একটি কার্যকর ইমেইল ঠিকানা দিন।',
            'author_phone.required' => 'আপনার সচল মোবাইল বা হোয়াটসঅ্যাপ নম্বর দিন।',
            'author_designation.required' => 'আপনার পেশা বা পদবি উল্লেখ করুন (যেমন: কলামিস্ট, শিক্ষক, ইত্যাদি)।',
            'title.required' => 'কলাম বা মতামতের একটি শিরোনাম দিন।',
            'title.min' => 'শিরোনাম অন্তত ১০ অক্ষরের হতে হবে।',
            'content.required' => 'কলামের বিস্তারিত বক্তব্য লিখুন।',
            'content.min' => 'লেখাটি অন্তত ১৫০ অক্ষরের হতে হবে।',
            'agreement.accepted' => 'পত্রিকার শর্তাবলী ও নির্দেশিকায় সম্মতি দিতে হবে।',
        ]);

        // Upload author photo if provided
        $authorPhotoPath = null;
        if ($request->hasFile('author_photo')) {
            $photoFile = $request->file('author_photo');
            $uploadDir = public_path('uploads/opinions/authors');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $photoName = time() . '_author_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $photoFile->getClientOriginalName());
            $photoFile->move($uploadDir, $photoName);
            $authorPhotoPath = 'uploads/opinions/authors/' . $photoName;
        }

        // Upload optional featured image if provided
        $featuredImagePath = null;
        if ($request->hasFile('featured_image')) {
            $featFile = $request->file('featured_image');
            $featDir = public_path('uploads/opinions/featured');
            if (!file_exists($featDir)) {
                mkdir($featDir, 0755, true);
            }
            $featName = time() . '_feat_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $featFile->getClientOriginalName());
            $featFile->move($featDir, $featName);
            $featuredImagePath = 'uploads/opinions/featured/' . $featName;
        }

        // Create submission record
        $submission = OpinionSubmission::create([
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'author_phone' => $request->author_phone,
            'author_designation' => $request->author_designation,
            'author_bio' => $request->author_bio,
            'author_photo' => $authorPhotoPath,
            'title' => $request->title,
            'topic' => $request->topic ?: 'সমসাময়িক বিষয়',
            'content' => $request->content,
            'featured_image' => $featuredImagePath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('submission_success', [
            'tracking_id' => $submission->id,
            'author_name' => $submission->author_name,
            'title' => $submission->title,
        ]);
    }
}
