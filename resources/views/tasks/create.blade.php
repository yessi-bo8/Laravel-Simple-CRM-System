@extends('layouts.app')
@section('content')
<div class="form-container" >
    <h1>New Project</h1>
    <div>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
            <label>Name:</label>
            <input type="text" name="name">
            @error('name')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />

            <label for="description">Description:</label>
            <textarea name="description" rows="4" cols="50"></textarea>
            @error('description')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />

            <label>Date deadline:</label>
            <input type="date" name="due_date" value="">
            @error('due_date')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            <br />

            <label for="client_name">Client:</label>
            <select name="client_name">
                <option value="">Select Client</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->name }}">{{ $client->name }}</option>
                @endforeach
            </select>
            @error('client_name')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br>

            <label for="project_title">Project:</label>
            <select name="project_title">
                <option value="">Select Project</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->title}}">{{ $project->title }}</option>
                @endforeach
            </select>
            @error('project_title')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br>

            <select name="status">
            <option value="">Select Status</option>
                <option value="approved">approved</option>
                <option value="pending">pending</option>
                <option value="rejected">rejected</option>
            </select>
            @error('status')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br >

            <select name="priority">
                <option value="">Select Priority</option>
                <option value="low">low</option>
                <option value="medium">medium</option>
                <option value="high">high</option>
            </select>
            @error('priority')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
            @enderror
            </br>

            <button type="submit">Make new Project</button>
        </form>

    </div>
    </div>
</div>
@endsection

