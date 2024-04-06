<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class WebController extends Controller
{
    public function index() 
    {
        $view = Route::is('projects.*') ? 'projects.index' : (Route::is('clients.*') ? 'clients.index' : 'home');
        return view($view);
    }

    public function create() 
    {
        $view = Route::is('projects.*') ? 'projects.create' : (Route::is('clients.*') ? 'clients.create' : 'home');
        return view($view);
    }



}
