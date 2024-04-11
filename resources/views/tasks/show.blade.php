@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
<div class="task-container">
    <h2>{{ $task->name }}</h2>
    <hr>
    <div class="task-details">
        <p><strong>Description:</strong></p>
        <p>{{ $task->description }}</p>
        <p><strong>User:</strong> {{ $task->user->name }}</p>
        <p><strong>Project:</strong> {{ $task->project->title }}</p>
        <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
        <p><strong>Status:</strong> {{ $task->status }}</p>
        <p><strong>Priority:</strong> {{ $task->priority }}</p>
        <p><strong>Client:</strong> {{ $task->client->name }}</p>
        @if ($task->user->id == '2')
            <a href="{{ route('tasks.edit', ['task' => $task]) }}" class="update-button">Update</a>
            <form action="{{ route('tasks.destroy', ['task' => $task]) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
            </form>
        @endif
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<a href="{{ route('tasks.index') }}" class="button">Back to all tasks</a>


@endsection
