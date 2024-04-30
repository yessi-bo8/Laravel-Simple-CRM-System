<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Traits\ErrorHandlingTrait;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Exceptions\ModelNotChangedException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TaskWebController extends Controller
{
    use AuthorizesRequests;
    use ErrorHandlingTrait;

    /**
     * Display a listing of the tasks.
     *
     * @return View The view for the task index page.
     */
    public function index(): View 
    {
        $user = auth()->user();
        Log::info('User roles: ' . $user->roles->pluck('name')->implode(', '));
        $tasks = Task::accessibleBy($user)->paginate(10);
        return view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Display the specified task.
     *
     * @param Task $task The task instance to be displayed.
     * @return View The view for the task show page.
     */
    public function show(Task $task): View
    {
        $this->authorize('show', $task);
        return view('tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for creating a new task.
     *
     * @return View The view for the task creation form.
     */
    public function create(): View 
    {
        $this->authorize('store', Task::class);
        //Return just the names and titles
        $users = User::pluck('name', 'id');
        $clients = Client::pluck('name', 'id');
        $projects = Project::pluck('title', 'id');
        return view('tasks.create', ['clients'=>$clients, 'projects' =>$projects, 'users'=>$users]);
    }

    /**
     * Store a newly created task.
     *
     * @param StoreTaskRequest $request The request containing the task data to be stored.
     * @return RedirectResponse The redirect response after storing the task.
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $this->authorize('store', Task::class);

        try {
            $validatedData = $request->validated();
            Log::info('Validated Data:', $validatedData);

            DB::beginTransaction();
            $task = Task::create($validatedData);
            DB::commit();

            return redirect()->route('tasks.show', ['task' => $task])->with('success', 'Task created successfully');
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Task", "store");
        }

    }

    /**
     * Show the form for editing the specified task.
     *
     * @param Task $task The task instance to be edited.
     * @return View The view for the task editing form.
     */
    public function edit(Task $task): View
    {
        $this->authorize('update', $task);
        //Return just the names and titles
        $clients = Client::pluck('name', 'id');
        $projects = Project::pluck('title', 'id');
        $users = User::pluck('name', 'id');
        return view('tasks.edit', ['task' => $task, 'clients'=>$clients, 'projects'=>$projects, 'users'=>$users]);
    }

     /**
     * Update the specified task in storage.
     *
     * @param UpdateTaskRequest $request The request containing the updated task data.
     * @param Task $task The task instance to be updated.
     * @return RedirectResponse The redirect response after updating the task.
     */    
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse 
    {
        $this->authorize('update', $task);

        try {
            $validatedData = $request->validated();

            DB::beginTransaction();
            if ($task->fill($validatedData)->isDirty()) {
                $task->update($validatedData);
            } else {
                throw new ModelNotChangedException();
            }
            DB::commit();

            return redirect()->route('tasks.show', ['task' => $task])
                            ->with('success', 'Task updated successfully');
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Task", "update");
        }
    }

     /**
     * Remove the specified task from storage.
     *
     * @param Task $task The task instance to be deleted.
     * @return RedirectResponse The redirect response after deleting the task.
     */
    public function destroy(Task $task): RedirectResponse 
    {
        $this->authorize('destroy', $task);

        try {

            DB::beginTransaction();
            $task->delete();
            DB::commit();

            return redirect()->route('tasks.index')
                ->with('success', 'Task deleted successfully');
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Task", "delete");
        }
    }

}
