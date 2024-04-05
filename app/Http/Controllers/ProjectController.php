<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Traits\HTTPResponses;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use HTTPResponses;
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Task::all()->toJson();;
        return ProjectResource::collection(
            Project::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
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
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        
        $project->update($request->only(['title', 'description', 'status']));
        return $this->checkAuth($project) ? $this->checkAuth($project) : new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('authorize', $project);
        $project->delete();
    }

    private function checkAuth($project)
    {
        if (Auth::id() !== $project->user_id) {
            return $this->error("", 'You are not Authorized', 403);
         }
    }
}
