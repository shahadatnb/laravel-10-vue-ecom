<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\mixTrait;
use Carbon\Carbon;
use Session;
use Auth;

class HomeController extends Controller
{
    use mixTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');//verified
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.pages.dashboard');
    }

    
}
