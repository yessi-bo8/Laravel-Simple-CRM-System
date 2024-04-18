@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
@can('store', App\Models\Task::class)
<a href="{{ route('tasks.create') }}"  class="create-button">Create Task</a>
@endcan
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="task-container">
<table class="task-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Project</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tasks as $task)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td><a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->name }}</a></td>
        <td class="{{ $task->status === 'pending' ? 'rejected-status' : ($task->status === 'completed' ? 'approved-status' : '') }}">{{ $task->status }}</td>
        <td class="project-cell">{{ $task->project->title }}</td> <!-- Add a class to the Project column -->
        <td class="action-buttons">
            @can('update', $task)
                <a href="{{ route('tasks.edit', ['task' => $task]) }}" class="update-button">Update</a>
            @endcan
            @can('delete', $task)
                <form action="{{ route('tasks.destroy', ['task' => $task]) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                </form>
            @endcan
        </td>
    </tr>
@endforeach

    </tbody>
</table>

</div>

<div class="pagination justify-content-center">
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($tasks->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">&laquo;</span>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $tasks->previousPageUrl() }}" class="page-link" rel="prev">&laquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($tasks as $task)
            <li class="page-item">{{ $task->title }}</li>
        @endforeach

        {{-- Next Page Link --}}
        @if ($tasks->hasMorePages())
            <li class="page-item">
                <a href="{{ $tasks->nextPageUrl() }}" class="page-link" rel="next">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">&raquo;</span>
            </li>
        @endif
    </ul>
</div>


@endsection
