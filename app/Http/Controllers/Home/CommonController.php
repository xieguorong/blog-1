<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        $navs = Nav::all();
        View::share('navs', $navs);
    }
}
