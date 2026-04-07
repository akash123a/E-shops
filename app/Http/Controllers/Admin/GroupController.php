<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = auth()->user()->groups;
        return view('groups.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $group = Group::create([
            'name' => $request->name,
            'created_by' => auth()->id()
        ]);

        $group->users()->attach(auth()->id());

        return back();
    }
}