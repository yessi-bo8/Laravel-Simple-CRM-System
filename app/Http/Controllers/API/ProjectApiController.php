<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Resources\ProjectResource;

use App\Models\Project;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;

use App\Traits\HTTPResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectApiController extends Controller
{
    use HTTPResponses;
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->roles->contains('name', 'admin');

        // Retrieve projects based on user's role
        if ($isAdmin) {
            $projects = Project::all();
        } else {
            $projects = $user->projects;
        }
        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        // $this->authorize('create', Project::class);
        // Find the client based on the provided client name
        $client = Client::where('name', $request->client_name)->firstOrFail();
        $request->validated($request->all());

        $project = Project::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'client_id' => $client->id,
            'status' => $request->status ? $request->status : 'pending',
        ]);

        return new ProjectResource($project);
        
    }

     /**
     * Display the specified resource.
     * with behind the scenes laravel magic! directly pass in Taks object
     */
    public function show(Project $project)
    {
        // $this->authorize('view', $project);
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $project->update($request->only(['title', 'description', 'status', 'event_date']));
        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
    }

}
