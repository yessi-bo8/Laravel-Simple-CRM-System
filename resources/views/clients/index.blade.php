@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
<div class="container">
    <h1>All clients</h1>
    <div id="clients-list">
        <!-- Projects will be dynamically added here -->
    </div>
    <div id="client-details">
        <!-- Project details will be dynamically updated here -->
    </div>
</div>
@endsection
