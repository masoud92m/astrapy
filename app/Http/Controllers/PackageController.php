<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function show($slug)
    {
        $package = Package::where('slug', $slug)->firstOrFail();
        return view('site.package', compact('package'));
    }
}
