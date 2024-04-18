<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Exceptions\DeleteException;
use App\Exceptions\NotFound\ProjectNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\StoreException;
use App\Exceptions\UpdateException;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Resources\ProjectResource;

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
        $user = auth()->user();
        $this->authorize('index', Project::class);
        $projects = Project::accessibleBy($user);
        $projectResources = ProjectResource::collection($projects);

        return $this->success($projectResources);
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
            throw new ProjectNotFoundException();
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
            throw new StoreException("Failed to store project: " . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        try {
            $this->authorize('update', $project);
            $project->update($request->only(['title', 'description', 'status', 'event_date']));

            $projectResource = new ProjectResource($project);
            return $this->success($projectResource);
        } catch (\Exception $e) {
            throw new UpdateException("Failed to update project: " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $this->authorize('delete', $project);
            $project->delete();
        } catch (\Exception $e) {
            throw new DeleteException("Failed to delete project: " . $e->getMessage());
        }
    }

}
