<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{


public function index()
{
    $users = User::all();
    return view('users.index', compact('users'));
}

public function __construct()
{
    $this->middleware('auth');
    $this->middleware('role:admin'); // seul un admin peut voir la liste
}


}


