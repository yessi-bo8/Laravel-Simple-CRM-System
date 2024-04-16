<?php

namespace App\Http\Controllers\API;

use App\Exceptions\DeleteException;
use App\Exceptions\NotFound\ProjectNotFoundException;
use App\Exceptions\StoreException;
use App\Exceptions\UpdateException;
use App\Http\Controllers\Controller;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Resources\ProjectResource;

use App\Models\Project;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;

use App\Traits\HTTPResponses;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        return ProjectResource::collection($projects);
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
            return new ProjectResource($project);
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

            return new ProjectResource($project);
        } catch (\Exception $e) {
            throw new StoreException("Failed to store project: " . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        try {
            $this->authorize('update', $project);
            $project->update($request->only(['title', 'description', 'status', 'event_date']));
            return new ProjectResource($project);
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
