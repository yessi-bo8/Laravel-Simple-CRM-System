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

public function show($id) 
    {
        $view = Route::is('projects.*') ? 'projects.show' : (Route::is('clients.*') ? 'clients.show' : 'home');
        return view($view, ['id' => $id]);
    }

}
