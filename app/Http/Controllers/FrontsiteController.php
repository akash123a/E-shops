<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;


class FrontsiteController extends Controller
{
    //
    public function home()
    {
        $sliders = Slider::where('status','active')->get();
        return view('frontend.home', compact('sliders'));
    }

}
