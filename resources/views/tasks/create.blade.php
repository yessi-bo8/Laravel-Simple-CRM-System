@extends('layouts.app')
@section('banner', 'Create Task')
@section('content')
<div class="form-container" >
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            @error('name')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />

            <label for="description">Description:</label>
            <textarea name="description" rows="4" cols="50" required></textarea>
            @error('description')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />

            <label>Date deadline:</label>
            <input type="date" name="due_date" value="" required>
            @error('due_date')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />

            <label for="client_id">Client:</label>
            <select name="client_id" required>
                <option value="">Select Client</option>
                @foreach ($clients as $clientId => $clientName)
                    <option value="{{ $clientId }}">{{ $clientName }}</option>
                @endforeach
            </select>
            @error('client_id')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br>

            <label for="user_id">Assigned to:</label>
            <select name="user_id" required>
                <option value="">Select User</option>
                @foreach ($users as $userId => $userName)
                    <option value="{{ $userId }}">{{ $userName }}</option>
                @endforeach
            </select>
            @error('user_id')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br>

            <label for="project_id">Project:</label>
            <select name="project_id" required>
                <option value="">Select Project</option>
                @foreach ($projects as $projectId => $projectTitle)
                    <option value="{{ $projectId }}">{{ $projectTitle }}</option>
                @endforeach
            </select>
            @error('project_id')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br>

            <label for="status">Status:</label>
            <select name="status" required>
            <option value="">Select Status</option>
                <option value="pending">pending</option>
                <option value="in progress">in progress</option>
                <option value="completed">completed</option>
            </select>
            @error('status')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br >

            <label for="priority">Priority:</label>
            <select name="priority" required>
                <option value="">Select Priority</option>
                <option value="low">low</option>
                <option value="medium">medium</option>
                <option value="high">high</option>
            </select>
            @error('priority')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br>

            <button type="submit">Make new Task</button>
        </form>

    </div>
</div>
@endsection

