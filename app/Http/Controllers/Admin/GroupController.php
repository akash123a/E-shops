<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function index()
    {
        $groups = auth()->user()->groups;
        return view('groups.index', compact('groups'));
    }


 public function addUser(Request $request)
{
    $request->validate([
        'group_id' => 'required|exists:groups,id',
        'user_id'  => 'required|exists:users,id',
    ]);

    $group = Group::findOrFail($request->group_id);

    $group->users()->syncWithoutDetaching([$request->user_id]);

    return back()->with('success', 'User added successfully');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $group = Group::create([
        'name' => $request->name,
        'created_by' => auth()->id()
    ]);

    if (auth()->check()) {
        $group->users()->syncWithoutDetaching([auth()->id()]);
    }

    return back()->with('success', 'Group Created');
}
}