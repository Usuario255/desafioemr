<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Redirect;
use Illuminate\Support\Facades\Mail;
use Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $countUser = User::all()->count();
        $users = User::get();
        return view('user.index', compact('users','countUser'));
    }

}
