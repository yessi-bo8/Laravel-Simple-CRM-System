<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class ProjectWebController extends Controller
{
    public function index() 
    {
        return view('projects.index');
    }

}