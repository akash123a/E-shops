<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    // 📌 Show all sliders
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.sliders.index', compact('sliders'));
    }

    // 📌 Show create form
    public function create()
    {
        return view('admin.sliders.create');
    }

    // 📌 Store new slider
    public function store(Request $request)
    {
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('uploads/sliders'), $imageName);
        }

        Slider::create([
            'title' => $request->title,
            'image' => $imageName,
        ]);

        return redirect()->route('sliders.index');
    }

    // 📌 Show edit form
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    // 📌 Update slider
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('uploads/sliders'), $imageName);

            $slider->image = $imageName;
        }

        $slider->title = $request->title;
        $slider->save();

        return redirect()->route('sliders.index');
    }

    // 📌 Delete slider
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        // delete image
        $path = public_path('uploads/sliders/'.$slider->image);
        if (file_exists($path)) {
            unlink($path);
        }

        $slider->delete();

        return redirect()->back();
    }
}