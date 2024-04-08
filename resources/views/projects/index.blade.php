@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
<div class="container">
    <a href="{{ route('projects.create') }}" class="button">Create Project</a>
    <div id="projects-list">
        <!-- Projects will be dynamically added here -->
    </div>
    <div id="project-details">
        <!-- Project details will be dynamically updated here -->
    </div>
</div>
@endsection
