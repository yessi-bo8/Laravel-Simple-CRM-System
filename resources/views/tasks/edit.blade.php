@extends('layouts.app')
@section('content')
<div class="form-container" >
    <h1>Edit project</h1>
    <div>
    <form action="{{ route('tasks.update', ['task'=>$task]) }}" method="POST">
        @csrf
        @method('PATCH')
            <label>Name:</label>
            <input type="text" name="name" value="{{ $task->name }}"> <!-- Fill in value from $task -->
            <br />

            <label for="description">Description:</label>
            <textarea name="description" rows="4" cols="50">{{ $task->description }}</textarea> <!-- Fill in value from $task -->
            <br />

            <label>Date deadline:</label>
            <input type="date" name="due_date" value="{{ $task->due_date }}"> <!-- Fill in value from $task -->
            <br />

            <label for="client_name">Client:</label>
            <select name="client_name">
                <!-- Default selected option -->
                <option value="{{ $task->client->name }}" selected>{{ $task->client->name }}</option>
                
                <!-- Other options -->
                @foreach ($clients as $client)
                    <!-- Exclude the default option -->
                    @if ($client->name !== $task->client->name)
                        <option value="{{ $client->name }}">{{ $client->name }}</option>
                    @endif
                @endforeach
            </select>
            <br>


            <label for="project_title">Project:</label>
            <select name="project_title">
                <!-- Default selected option -->
                <option value="{{ $task->project->title }}" selected>{{ $task->project->title }}</option>
                
                <!-- Other options -->
                @foreach ($projects as $project)
                    <!-- Exclude the default option -->
                    @if ($project->title !== $task->project->title)
                        <option value="{{ $project->title }}">{{ $project->title }}</option>
                    @endif
                @endforeach
            </select>
            <br>

            <select name="status">
                <option value="approved" {{ $task->status == 'approved' ? 'selected' : '' }}>approved</option> <!-- Fill in value from $task and set selected if matches -->
                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>pending</option>
                <option value="rejected" {{ $task->status == 'rejected' ? 'selected' : '' }}>rejected</option>
            </select>
            </br >

            <select name="priority">
                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>low</option> <!-- Fill in value from $task and set selected if matches -->
                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>medium</option>
                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>high</option>
            </select>
            </br>

            <button type="submit">Edit Project</button>
        </form>

    </div>
</div>
@if($errors->has('no_changes'))
    <div class="alert alert-error">
        {{ $errors->first('no_changes') }}
    </div>
@endif
@endsection

