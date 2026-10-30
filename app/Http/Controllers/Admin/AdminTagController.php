<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class AdminTagController extends Controller
{
    /**
     * Display a listing of tags with post counts.
     */
    public function index(Request $request)
    {
        Gate::authorize('admin-or-super');
        $search = $request->query('search', '');
        
        $query = Tag::withCount('posts')->orderBy('name', 'asc');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $tags = $query->paginate(20);

        return view('admin.tags.index', compact('tags', 'search'));
    }

    /**
     * Store a newly created tag in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin-or-super');
        $request->validate([
            'name' => 'required|string|max:150|unique:tags,name',
            'slug' => 'nullable|string|max:150|unique:tags,slug',
        ], [
            'name.required' => 'ট্যাগের নাম আবশ্যক।',
            'name.unique' => 'এই নামের ট্যাগটি ইতিমধ্যে রয়েছে।',
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);
        if (empty($slug)) {
            $slug = 'tag-' . time();
        }

        $originalSlug = $slug;
        $count = 1;
        while (Tag::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Tag::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'নতুন ট্যাগ সফলভাবে তৈরি করা হয়েছে।');
    }

    /**
     * Update the specified tag.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('admin-or-super');
        $tag = Tag::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:150|unique:tags,name,' . $tag->id,
            'slug' => 'nullable|string|max:150|unique:tags,slug,' . $tag->id,
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);
        if (empty($slug)) {
            $slug = $tag->slug ?: 'tag-' . $tag->id;
        }

        $tag->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'ট্যাগটি সফলভাবে হালনাগাদ করা হয়েছে।');
    }

    /**
     * Remove the specified tag from storage.
     */
    public function destroy($id)
    {
        Gate::authorize('admin-or-super');
        $tag = Tag::findOrFail($id);

        // Detach pivot relations first
        $tag->posts()->detach();
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'ট্যাগ সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
