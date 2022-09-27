<?php

namespace App\Http\Controllers\Web;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(): View
    {
        return view('user.index');
    }

    public function create(): View
    {
        return view('user.create');
    }
}
