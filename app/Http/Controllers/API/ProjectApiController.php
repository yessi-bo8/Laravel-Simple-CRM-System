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
    public function store(StoreProjectRequest $request, Project $project)
    {
        $this->authorize('store', $project);
        // dd($request->client_name);
        $request->validated($request->all());

        // Find the user and client based on the provided names
        try {
        $user = User::where('name', $request->user_name)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['error' => 'User not found'], 404);
        }
        try {
        $client = Client::where('name', $request->client_name)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $project = Project::create([
            'user_id' => $user->id,
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
        $this->authorize('show', $project);
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
