<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ExpenseController;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin(){
        return view('admin.login');
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $request->email)->first();
 
        if ($admin && Hash::check($request->password, $admin->password)) {
            Session::put('admin', $admin->id);
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('error', 'Invalid Credentials');
    }

    public function showAddUserForm($id)
    {
        $group = Group::findOrFail($id);
        $users = User::all();

        return view('admin.groups.add-user', compact('group', 'users'));
    }

  

public function dashboard()
{
    if (!Session::has('admin')) {
        return redirect('/admin/login');
    }

    $admin = $this->getAdminFromSession();
    if (!$admin) {
        Session::forget('admin');
        return redirect('/admin/login');
    }

    // ✅ Load groups with users + expenses + splits
    $groups = Group::with(['creator', 'users', 'expenses.splits'])->get();

    $expenseController = new ExpenseController();

    $balances = [];
    $settlements = [];
    $group = null;

    // ⚠️ TEMP: only first group (we improve later)
    if ($groups->count() > 0) {
        $group = $groups->first();

        $balances = $expenseController->calculateBalances($group->id);
        $settlements = $expenseController->simplifyDebts($balances);
    }

    return view('admin.dashboard', compact('admin', 'groups', 'balances', 'settlements', 'group'));
}

    public function logout(Request $request)
    {
        Session::forget('admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    // Register
    public function showRegister()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|confirmed'
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/admin/login')->with('success', 'Admin Registered Successfully');
    }

    // Show Change Password Page
    public function showChangePassword()
    {
        if (!Session::has('admin')) {
            return redirect('/admin/login');
        }

        return view('admin.change-password');
    }

    // Handle Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed'
    ]);

    $admin = $this->getAdminFromSession();

    if (!$admin) {
        Session::forget('admin');
        return redirect('/admin/login');
    }

        // Check current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        // Update password
        $admin->password = Hash::make($request->new_password);
        $admin->save();
       
        return back()->with('success', 'Password changed successfully');
    }

    protected function getAdminFromSession()
    {
        return Admin::find(Session::get('admin'));
    }




}