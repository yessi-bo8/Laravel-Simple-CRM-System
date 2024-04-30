<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ModelNotChangedException;
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
     * Display a listing of the projects.
     *
     * @return JsonResponse The JSON response containing the list of projects.
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
     * Display the specified project.
     *
     * @param int $projectId The ID of the project to be displayed.
     * @return JsonResponse The JSON response containing the project data.
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
     * Store a newly created project.
     *
     * @param StoreProjectRequest $request The request containing the project data to be stored.
     * @param Project $project The project instance.
     * @return JsonResponse The JSON response indicating the success or failure of the operation.
     */
    public function store(StoreProjectRequest $request, Project $project): JsonResponse
    {
        try {
            $this->authorize('store', $project);
            
            DB::beginTransaction();
            $validatedData = $request->validated();
            $validatedData['status'] = $request->status ?? 'pending';
            $project = Project::create($validatedData);
            DB::commit();

            $projectResource = new ProjectResource($project);
            return $this->success($projectResource);
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Project", "store");
        }
    }

    /**
     * Update the specified project.
     *
     * @param UpdateProjectRequest $request The request containing the updated project data.
     * @param Project $project The project instance to be updated.
     * @return JsonResponse The JSON response indicating the success or failure of the operation.
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        try {
            $this->authorize('update', $project);

            DB::beginTransaction();
            $validatedData = $request->validated();
            if ($project->fill($validatedData)->isDirty()) {
                $project->update($validatedData);
            } else {
                throw new ModelNotChangedException();
            }
            DB::commit();

            $projectResource = new ProjectResource($project);
            return $this->success($projectResource);
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Project", "update");
        }
    }

    /**
     * Remove the specified project from storage.
     *
     * @param Project $project The project instance to be deleted.
     * @return JsonResponse The JSON response indicating the success or failure of the operation.
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
