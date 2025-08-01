<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    echo 'Api ' . \Carbon\Carbon::now();
});

