<?php

# Namespace
namespace App\Http\Controllers;

# Utilities
use Illuminate\Http\Request;

/**
 * Home Controller
 * Dev: Pavan Kumar
 */
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
    return view('home');
  }

}
