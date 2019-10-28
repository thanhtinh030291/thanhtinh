<?php

namespace App\Http\Controllers;
use App\HBS_CL_CLAIM;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = HBS_CL_CLAIM::with('HBS_CL_LINE')->findOrFail(5026631);
        return view('home');
    }
}
