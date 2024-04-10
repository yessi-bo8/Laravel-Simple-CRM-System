<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index() 
    {
        // Paginate the tasks with 10 tasks per page (adjust as needed)
        $tasks = Task::paginate(10);

        // Wrap each task in a TaskResource instance
        $tasks = TaskResource::collection($tasks);
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function show(Task $task)
    {
        $task_return = new TaskResource($task);
        return view('tasks.show', ['task' => $task_return]);
    }

    public function create()
    {
        $clients = Client::all();
        $projects = Project::all();
        return view('tasks.create', ['clients'=>$clients, 'projects' =>$projects]);
    }

    public function store(StoreTaskRequest $request)
    {
        // Perform validation
        $validatedData = $request->validated();

        // Find the client based on the provided client name
        $client = Client::where('name', $validatedData['client_name'])->firstOrFail();
        $project = Project::where('title', $validatedData['project_title'])->firstOrFail();

        // Create task
        $task = Task::create([
            'user_id' => '2', // You might need to adjust this value
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
            $clients = Client::all();
            $projects = Project::all();
            return view('tasks.edit', ['task' => $task, 'clients'=>$clients, 'projects'=>$projects]);
        }


        
        public function update(UpdateTaskRequest $request, Task $task) {

            // Validate the incoming request data
            $validatedData = $request->validated();

            // Update the task with the validated data
            $task->update($validatedData);

            // Redirect the user to a relevant page or route
            return redirect()->route('tasks.show', ['task' => $task])
                            ->with('success', 'Task updated successfully');

        }

        public function destroy(Task $task) {
            $task->delete();
            return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully');
        }

}
