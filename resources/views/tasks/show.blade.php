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
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


@endsection
