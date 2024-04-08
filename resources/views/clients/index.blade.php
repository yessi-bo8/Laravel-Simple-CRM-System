@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
<div class="container">
    <h1>All clients</h1>
    <div id="clients-list">
        <!-- Projects will be dynamically added here -->
        Client List
    </div>
    <div id="clients-details">
        <!-- Project details will be dynamically updated here -->
    </div>
</div>
@endsection
