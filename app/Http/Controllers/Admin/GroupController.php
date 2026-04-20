<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use App\Models\Admin;

class GroupController extends Controller
{
    public function index()
{
    // Check if admin is logged in
    if (!session()->has('admin')) {
        return redirect('/admin/login');
    }

    // Get admin from session
    $admin = Admin::find(session('admin'));

    // Get all groups created by this admin, including users and creator relationship
    $groups = Group::with('users', 'creator')
                ->where('created_by', $admin->id)
                ->get();

    // Optional: balances array if needed
    $balances = [];

    // Pass data to dashboard view
    return view('admin.dashboard', compact('admin', 'groups', 'balances'));
}

    public function showAddUserForm($id)
{
    $group = Group::findOrFail($id);
    $users = User::all();

    return view('admin.groups.add-user', compact('group', 'users'));
}


 public function addUser(Request $request)
{
    // Validate input
    $request->validate([
        'group_id' => 'required|exists:groups,id',
        'user_name' => 'required|string|max:255', // <-- changed from user_id to user_name
    ]);

    $group = Group::findOrFail($request->group_id);

    // Find user by name or create new one
    $user = User::firstOrCreate(
    ['email' => $request->email], // ✅ unique key
    [
        'name' => $request->user_name,
        'password' => bcrypt('password')
    ]
);
    // Add user to group
    $group->users()->syncWithoutDetaching([$user->id]);

    return redirect()->route('admin.dashboard')->with('success', 'User added successfully');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);


    $adminId = session('admin'); // get logged-in admin

    // Check if group already exists for this admin
    $existingGroup = Group::where('name', $request->name)
                          ->where('created_by', $adminId)
                          ->first();

    if ($existingGroup) {
        // Group already exists
        return back()->with('error', 'Group with this name already exists.');
    }

    // Create new group
    $group = Group::create([
        'name' => $request->name,
        'created_by' => $adminId
    ]);

    // Add creator to group members
    $group->users()->syncWithoutDetaching([$adminId]);

    return back()->with('success', 'Group created successfully.');

    // $group = Group::create([
    //     'name' => $request->name,
    //     'created_by' => auth()->id()
    // ]);

    // if (auth()->check()) {
    //     $group->users()->syncWithoutDetaching([auth()->id()]);
    // }

    // return back()->with('success', 'Group Created');
}
}