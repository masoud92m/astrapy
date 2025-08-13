<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function getAnalysis()
    {
        return view('admin.packages.get-analysis');
    }
}
