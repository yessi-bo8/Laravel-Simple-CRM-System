<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\DeleteException;
use App\Exceptions\StoreException;
use App\Exceptions\UpdateException;
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
        $user = auth()->user();
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
            
            return redirect()->route('tasks.show', ['task' => $task]);
        } catch (\Exception $e) {
            throw new StoreException("Failed to store task: " . $e->getMessage());
        }

        }

        public function edit(Task $task){
            //Return just the names and titles
            $clients = Client::pluck('name', 'id');
            $projects = Project::pluck('title', 'id');
            return view('tasks.edit', ['task' => $task, 'clients'=>$clients, 'projects'=>$projects]);
        }
        
        public function update(UpdateTaskRequest $request, Task $task) {
            try {
                $this->authorize('update', Task::class);
                $validatedData = $request->validated();
                $task->update($validatedData);

                // Redirect the user to a relevant page or route
                return redirect()->route('tasks.show', ['task' => $task])
                                ->with('success', 'Task updated successfully');
            } catch (\Exception $e) {
                throw new UpdateException("Failed to Update task: " . $e->getMessage());
            }
        }

        public function destroy(Task $task) {
            try {
            $this->authorize('delete', Task::class);
            $task->delete();
            return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully');
            } catch (\Exception $e) {
                throw new DeleteException("Failed to Delete task: " . $e->getMessage());
            }
        }

}
