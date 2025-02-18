<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BnHController extends Controller
{
    public function index () {
        return view('beautyHealth');
    }
}
