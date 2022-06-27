<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function detail($slug){
        $page = Page::where('slug', $slug)->first();
        return view('client.page.detail', compact('page'));
    }
}
