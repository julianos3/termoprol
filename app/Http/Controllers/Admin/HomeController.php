<?php

namespace AgenciaS3\Http\Controllers\Admin;

use AgenciaS3\Http\Controllers\Controller;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config['title'] = "Home";
        $config['activeMenu'] = 'home';
        return view('admin.home.index', compact('config'));
    }
}
