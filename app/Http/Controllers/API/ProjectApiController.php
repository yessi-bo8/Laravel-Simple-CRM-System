<?php

namespace App\Http\Controllers\API;

use App\Traits\ErrorHandlingTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Project;

use App\Traits\HTTPResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

class ProjectApiController extends Controller
{
    use HTTPResponses;
    use AuthorizesRequests;
    use ErrorHandlingTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->authorize('index', Project::class);
        $user = auth()->user();
        $projects = Project::accessibleBy($user);
        $projectResources = ProjectResource::collection($projects);
        return $this->success($projectResources);
    }

    /**
    * Display the specified resource.
    */
    public function show($projectId): JsonResponse
    {
        try{ 
            $project = Project::findOrFail($projectId);
            $this->authorize('show', $project);
            $projectResource = new ProjectResource($project);
            return $this->success($projectResource);
        } catch (ModelNotFoundException $e) {
            return $this->error(null, 'Project not found', 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request, Project $project): JsonResponse
    {
        try {
            $this->authorize('store', $project);
            DB::beginTransaction();
            $requestData = $request->validated();
            $requestData['status'] = $request->status ?? 'pending';
            $project = Project::create($requestData);
            $projectResource = new ProjectResource($project);
            DB::commit();

            return $this->success($projectResource);
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Project", "store");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        try {
            $this->authorize('update', $project);
            DB::beginTransaction();
            $project->update($request->only(['title', 'description', 'status', 'event_date', 'user_id', 'client_id']));
            $projectResource = new ProjectResource($project);
            DB::commit();

            return $this->success($projectResource);
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Project", "update");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): JsonResponse
    {
        try {
            $this->authorize('destroy', $project);
            DB::beginTransaction();
            $project->delete();
            DB::commit();

            return $this->success(null, "Project deleted successfully.");
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Project", "delete");
        }
    }

}
