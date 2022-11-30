<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        dd('index function');
    }
    public function update(User $user){
        dd($user);
    }
}
