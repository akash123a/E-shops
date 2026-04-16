<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Navbar;




class NavbarController extends Controller
{
    // SHOW ALL
public function index()
{
    $navbars = Navbar::with('parent')
        ->orderBy('order')
        ->get();

    $parents = Navbar::whereNull('parent_id')->get();

    return view('admin.navbar.index', compact('navbars', 'parents'));
}


    public function reorder(Request $request)
{
    foreach ($request->order as $index => $id) {
        \App\Models\Navbar::where('id', $id)->update([
            'order' => $index + 1
        ]);
    }

    return response()->json(['success' => true]);
}



    // STORE
    public function store(Request $request)
    {
        Navbar::create($request->all());
        return back()->with('success', 'Menu Added Successfully');
    }

    // EDIT PAGE
    public function edit($id)
    {
        $navbar = Navbar::findOrFail($id);
        return view('admin.navbar.edit', compact('navbar'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $navbar = Navbar::findOrFail($id);
        $navbar->update($request->all());

        return redirect()->route('navbar.index')->with('success', 'Menu Updated');
    }

    // DELETE
    public function delete($id)
    {
        Navbar::findOrFail($id)->delete();
        return back()->with('success', 'Menu Deleted');
    }
}