@extends('layouts.app')
@section('banner', 'Update Task')
@section('content')

<div class="form-container" >
    <div>
    <form action="{{ route('tasks.update', ['task'=>$task]) }}" method="POST">
        @csrf
        @method('PATCH')
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ $task->name }}" required> <!-- Fill in value from $task -->
            @error('name')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />

            <label for="description">Description:</label>
            <textarea name="description" rows="4" cols="50" required>{{ $task->description }}</textarea> <!-- Fill in value from $task -->
            @error('description')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />
            

            <label>Date deadline:</label>
            <input type="date" name="due_date" value="{{ $task->due_date }}" required> <!-- Fill in value from $task -->
            @error('due_date')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />

            <label for="client_id">Client:</label>
            <select name="client_id" required>
                <!-- Default selected option -->
                <option value="{{ $task->client->id }}" selected>{{ $task->client->name }}</option>
                
                <!-- Other options -->
                @foreach ($clients as $clientId => $clientName)
                    <!-- Exclude the default option -->
                    @if ($clientId !== $task->client->id)
                        <option value="{{ $clientId }}">{{ $clientName }}</option>
                    @endif
                @endforeach
            </select>
            @error('client_id')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />

            <label for="user_id">Assigned to:</label>
            <select name="user_id" required>
                <!-- Default selected option -->
                <option value="{{ $task->user->id }}" selected>{{ $task->user->name }}</option>
                
                <!-- Other options -->
                @foreach ($users as $userId => $userName)
                    <!-- Exclude the default option -->
                    @if ($userId !== $task->user->id)
                        <option value="{{ $userId }}">{{ $userName }}</option>
                    @endif
                @endforeach
            </select>
            @error('user_id')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br>

            <label for="project_id">Project:</label>
            <select name="project_id" required>
                <!-- Default selected option -->
                <option value="{{ $task->project->id }}" selected>{{ $task->project->title }}</option>
                
                <!-- Other options -->
                @foreach ($projects as $projectId => $projectTitle)
                    <!-- Exclude the default option -->
                    @if ($projectId !== $task->project->id)
                        <option value="{{ $projectId }}">{{ $projectTitle }}</option>
                    @endif
                @endforeach
            </select>
            @error('project_id')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="approved" {{ $task->status == 'approved' ? 'selected' : '' }}>approved</option> <!-- Fill in value from $task and set selected if matches -->
                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>pending</option>
                <option value="rejected" {{ $task->status == 'rejected' ? 'selected' : '' }}>rejected</option>
            </select>
            @error('status')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br >

            <label for="priority">Priority:</label>
            <select name="priority" required>
                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>low</option> <!-- Fill in value from $task and set selected if matches -->
                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>medium</option>
                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>high</option>
            </select>
            @error('priority')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br >

            <button type="submit">Edit Task</button>
        </form>

    </div>
</div>
@endsection

