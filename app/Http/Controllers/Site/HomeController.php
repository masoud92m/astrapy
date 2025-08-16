<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $packages = Package::whereNotNull('published_at')->get();
        return view('site.home', compact('packages'));
    }
}
