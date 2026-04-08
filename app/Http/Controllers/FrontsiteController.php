<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Group;
use App\Models\User;



class FrontsiteController extends Controller
{
    //
    public function home()
    {
        $sliders = Slider::where('status','active')->get();
        $groups= Group::all();
         $balances = [];
        
        return view('frontend.home', compact('sliders', 'groups', 'balances' ));
    }

}
    