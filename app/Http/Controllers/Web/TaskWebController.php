<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskWebController extends Controller
{
    use AuthorizesRequests;

    public function index() 
    {
        // Paginate the tasks with 10 tasks per page (adjust as needed)
        $tasks = Task::paginate(10);

        // Return the tasks directly to the view without wrapping them in TaskResource
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function show(Task $task)
    {
        return view('tasks.show', ['task' => $task]);
    }

    public function create()
    {
        $users = User::pluck('name', 'id');
        $clients = Client::pluck('name', 'id');
        $projects = Project::pluck('title', 'id');
        return view('tasks.create', ['clients'=>$clients, 'projects' =>$projects, 'users'=>$users]);
    }

    public function store(StoreTaskRequest $request)
    {
        $this->authorize('store', Task::class);
        // Perform validation
        $validatedData = $request->validated();

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
        try {
            $project = Project::where('title', $validatedData['project_title'])->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        // Create task
        $task = Task::create([
            'user_id' => $user->id, // You might need to adjust this value
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'project_id' => $project->id,
            'status' => $validatedData['status'] ?? 'pending',
            'client_id' => $client->id,
            'priority' => $validatedData['priority'],
        ]);

        // Redirect the user to a new page with a success message or show a view
        return redirect()->route('tasks.show', ['task' => $task]);

        }

        public function edit(Task $task){
            $clients = Client::pluck('name', 'id');
            $projects = Project::pluck('title', 'id');
            return view('tasks.edit', ['task' => $task, 'clients'=>$clients, 'projects'=>$projects]);
        }


        
        public function update(UpdateTaskRequest $request, Task $task) {
            $this->authorize('update', Task::class);

            // Validate the incoming request data
            $validatedData = $request->validated();

            // Update the task with the validated data
            $task->update($validatedData);

            // Redirect the user to a relevant page or route
            return redirect()->route('tasks.show', ['task' => $task])
                            ->with('success', 'Task updated successfully');

        }

        public function destroy(Task $task) {
            $this->authorize('delete', Task::class);
            $task->delete();
            return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully');
        }

}
