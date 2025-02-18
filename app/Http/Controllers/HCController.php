<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HCController extends Controller
{
    public function index () {
        return view('homeCare');
    }
}
