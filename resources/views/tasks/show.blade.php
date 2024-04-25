@extends('layouts.app')
@section('banner', 'Current Task')
@vite(['resources/js/app.js'])
@section('content')
<div class="task-details">
    <div class="details-header">
    <h2>{{ $task->name }}</h2>
    </div>
    <div class="details-content">
        <p><strong>Description:</strong></p>
        <p>{{ $task->description }}</p>
        <p><strong>Assigned to:</strong> {{ $task->user->name }}</p>
        <p><strong>Project:</strong> {{ $task->project->title }}</p>
        <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
        <p><strong>Status:</strong> {{ $task->status }}</p>
        <p><strong>Priority:</strong> {{ $task->priority }}</p>
        <p><strong>Client:</strong> {{ $task->client->name }}</p>
    </div>
    <div class="details-footer">
        @can('update', $task)
            <a href="{{ route('tasks.edit', ['task' => $task]) }}" class="update-task">Update</a>
        @endcan
        @can('destroy', $task)
            <form action="{{ route('tasks.destroy', ['task' => $task]) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-task" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
            </form>
        @endcan
        <a href="{{ route('tasks.index') }}" class="button">Back to all tasks</a>
    </div>
</div>


@endsection
