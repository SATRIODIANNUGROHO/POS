<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FnBController extends Controller
{
    public function index () {
        return view('foodAndBeverage');
    }
}
