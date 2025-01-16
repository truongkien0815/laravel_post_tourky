<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LangController extends Controller
{
    public function index(Request $request, $lang)
    {
        if($lang)
        {
            Session::put('lang',$lang);
        }
       return redirect()->back();
    }
}
