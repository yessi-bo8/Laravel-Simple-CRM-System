@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
<div class="client-containerr">
    <h1>All clients</h1>
    <a href="{{ route('clients.create') }}" class="button">Create Client</a>
    @foreach ($clients as $index => $client)
    <div class='client-list'>
        <a href='#' class="client-details-link" data-client-id="{{$client->id}}">{{$client->name}}</a>
        @if (true)
            <a href="{{ route('clients.edit', ['client' => $client]) }}" class="update-button">Update</a>
            <button class='delete-client' data-client-id='{{$client->id}}' onclick="return confirm('Are you sure you want to delete this Client?')">Delete</button>
        @endif
    </div>
    @endforeach
</div>
<div class="client-details">
        <!-- Project details will be dynamically updated here -->
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">


@endsection
