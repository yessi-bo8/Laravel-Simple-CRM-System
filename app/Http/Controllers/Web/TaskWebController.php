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

use App\Services\TaskService;

use App\Exceptions\NotFound\TaskNotFoundException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TaskWebController extends Controller
{
    use AuthorizesRequests;
    use ErrorHandlingTrait;

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }


    public function index() 
    {
        $user = auth()->user();
        Log::info('User roles: ' . $user->roles->pluck('name')->implode(', '));
        $tasks = Task::accessibleBy($user)->paginate(10);
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function show(Task $task)
    {
        $this->authorize('show', $task);
        return view('tasks.show', ['task' => $task]);
    }

    public function create()
    {
        //Return just the names and titles
        $users = User::pluck('name', 'id');
        $clients = Client::pluck('name', 'id');
        $projects = Project::pluck('title', 'id');
        return view('tasks.create', ['clients'=>$clients, 'projects' =>$projects, 'users'=>$users]);
    }

    public function store(StoreTaskRequest $request)
    {
        try {
            $this->authorize('store', Task::class);
            $validatedData = $request->validated();
            Log::info('Validated Data:', $validatedData);

            DB::beginTransaction();
            $task = Task::create([
                'user_id' => $validatedData['user_id'],
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'due_date' => $validatedData['due_date'],
                'project_id' => $validatedData['project_id'],
                'status' => $validatedData['status'] ?? 'pending',
                'client_id' => $validatedData['client_id'],
                'priority' => $validatedData['priority'],
            ]);
            DB::commit();
            return redirect()->route('tasks.show', ['task' => $task])->with('success', 'Task created successfully');
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Task", "store");
        }

    }

    public function edit(Task $task){
        //Return just the names and titles
        $clients = Client::pluck('name', 'id');
        $projects = Project::pluck('title', 'id');
        $users = User::pluck('name', 'id');
        return view('tasks.edit', ['task' => $task, 'clients'=>$clients, 'projects'=>$projects, 'users'=>$users]);
    }
        
    public function update(UpdateTaskRequest $request, Task $task) {
        
        try {
            $this->authorize('update', $task);
            DB::beginTransaction();
            $validatedData = $request->all();
            $updatedTask = $this->taskService->updateTask($task, $validatedData);

            DB::commit();
            return redirect()->route('tasks.show', ['task' => $updatedTask])
                            ->with('success', 'Task updated successfully');
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Task", "update");
        }
    }

    public function destroy(Task $task) 
    {
        try {
            DB::beginTransaction();
            $this->authorize('destroy', $task);
            $task->delete();
            DB::commit();
            return redirect()->route('tasks.index')
                ->with('success', 'Task deleted successfully');
        } catch (\Exception $e) {
            return $this->handleExceptions($e, "Task", "delete");
        }
    }

}
