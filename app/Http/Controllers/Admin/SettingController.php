<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    // LIST
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    // CREATE PAGE
    public function create()
    {
        return view('admin.settings.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:settings,key',
            'value' => 'nullable',
            'file' => 'nullable|image'
        ]);

        $value = $request->value;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);
            $value = $filename;
        }

        Setting::create([
            'key' => $request->key,
            'value' => $value
        ]);

        return redirect()->route('settings.index')->with('success', 'Setting created');
    }

    // EDIT PAGE
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('admin.settings.edit', compact('setting'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $value = $request->value;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);
            $value = $filename;
        }

        $setting->update([
            'key' => $request->key,
            'value' => $value
        ]);

        return redirect()->route('settings.index')->with('success', 'Updated');
    }

    // DELETE
    public function destroy($id)
    {
        Setting::findOrFail($id)->delete();
        return back()->with('success', 'Deleted');
    }
}