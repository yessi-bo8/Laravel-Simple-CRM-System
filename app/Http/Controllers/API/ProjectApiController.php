<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Project;

use App\Traits\HTTPResponses;


class ProjectApiController extends Controller
{
    use HTTPResponses;
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
        $user = auth()->user();
        $this->authorize('index', Project::class);
        $projects = Project::accessibleBy($user);
        $projectResources = ProjectResource::collection($projects);
        return $this->success($projectResources);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return $this->error("", 'You do not have permission to view any projects.', 403);
        } catch (\Exception $e) {
            return $this->error("", 'An error occurred while processing your request.', 500);
        }
    }

    /**
    * Display the specified resource.
    * with behind the scenes laravel magic! directly pass in Taks object
    */
    public function show($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            $this->authorize('show', $project);
            $projectResource = new ProjectResource($project);
            return $this->success($projectResource);
        } catch (ModelNotFoundException $exception) {
            return $this->error(null, 'Failed to show project: ' . $exception->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request, Project $project)
    {
        try {
            $this->authorize('store', $project);
            $request->validated($request->all());

            $project = Project::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'description' => $request->description,
                'event_date' => $request->event_date,
                'client_id' => $request->client_id,
                'status' => $request->status ? $request->status : 'pending',
            ]);

            $projectResource = new ProjectResource($project);
            return $this->success($projectResource);
        } catch (\Exception $e) {
            return $this->error(null, 'Failed to store project: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        try {
            $this->authorize('update', $project);
            $project->update($request->only(['title', 'description', 'status', 'event_date', 'user_id', 'client_id']));

            $projectResource = new ProjectResource($project);
            return $this->success($projectResource);
        } catch (\Exception $e) {
            return $this->error(null, 'Failed to update project: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $this->authorize('destroy', $project);
            $project->delete();
        } catch (\Exception $e) {
            return $this->error(null, 'Failed to delete project: ' . $e->getMessage(), 500);
        }
    }

}
