@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
<div class="container">
    <h1>All my projects</h1>
    <div id="projects-list">
        <!-- Projects will be dynamically added here -->
    </div>
    <div id="project-details">
        <!-- Project details will be dynamically updated here -->
    </div>
</div>
@endsection
