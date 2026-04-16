<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // LIST
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.pages.create');
    }

      public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('frontend.page', compact('page'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content
        ]);

        return redirect()->route('pages.index')->with('success', 'Page Created');
    }

    // EDIT FORM
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $page->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content
        ]);

        return redirect()->route('pages.index')->with('success', 'Page Updated');
    }

    // DELETE
    public function delete($id)
    {
        Page::findOrFail($id)->delete();
        return back()->with('success', 'Page Deleted');
    }
}