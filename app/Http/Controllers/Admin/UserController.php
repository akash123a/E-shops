<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
      
          $users = User::all();
    return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
 public function edit($id)
{
    $user = User::findOrFail($id);
    return view('admin.users.edit', compact('user'));
}

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
    ]);

    $user = User::findOrFail($id);

    $user->name = $request->name;
    $user->email = $request->email;

    // Optional: update password only if filled
    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('users.index')->with('success', 'User Updated Successfully');
}

    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return back()->with('success', 'User Deleted Successfully');
}
}
