<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News, App\Page;
use App\NewsCategory as Category;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\facades\Session;
use App\Mail\SendMail;


class AboutController extends Controller
{
    use \App\Traits\LocalizeController;

    public $data = [];

    public function index($slug)
    {
        $this->localized();
        $page = Page::where('slug', $slug)->first();
        $this->data['page'] = $page;

        // $templateName = 'theme.' . $page->template . '.index';
        $templateName = 'theme.about.index';

        if (View::exists($templateName))
            return view($templateName, $this->data)->compileShortcodes();
        else
            return redirect(url('/'));
    }
   
   

}
