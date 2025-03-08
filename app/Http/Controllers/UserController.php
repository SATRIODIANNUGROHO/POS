<?php

namespace App\Http\Controllers;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $user = UserModel::create(
            [
                'username' => 'manager11',
                'nama' => 'Manager11',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ]
        );
        $user -> username = 'manager12';
        
        $user -> save();

        $user -> wasChanged(); // True
        $user -> wasChanged('username'); // True
        $user -> wasChanged(['username', 'level_id']); // True
        $user -> wasChanged('nama'); // False
        $user -> wasChanged(['nama', 'username']); // True
    }
}