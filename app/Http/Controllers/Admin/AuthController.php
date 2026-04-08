<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Group;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

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

        if($admin && Hash::check($request->password, $admin->password)){
            session(['admin' => $admin->id]);
            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Invalid Credentials');
    }

    public function dashboard(){

        if(!session()->has('admin')){
            return redirect('/admin/login');
        }
    $groups = Group::with(['creator', 'users'])->get();
     $users = User::all();
       $balances = [];
       
        $admin = Admin::find(session('admin'));

        return view('admin.dashboard', compact('admin', 'groups', 'balances','users'));
    }

    public function logout(){
        session()->forget('admin');
        return redirect('/admin/login');
    }

    // Register
    public function showRegister(){
        return view('admin.register');  
    }

    public function register(Request $request){

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
public function showChangePassword(){

    if(!session()->has('admin')){
        return redirect('/admin/login');
    }

    return view('admin.change-password');
}

// Handle Change Password
public function changePassword(Request $request){

    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed'
    ]);

    $admin = \App\Models\Admin::find(session('admin'));

    // Check current password
    if(!\Illuminate\Support\Facades\Hash::check($request->current_password, $admin->password)){
        return back()->with('error', 'Current password is incorrect');
    }

    // Update password
    $admin->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
    $admin->save();

    return back()->with('success', 'Password changed successfully');
}



}