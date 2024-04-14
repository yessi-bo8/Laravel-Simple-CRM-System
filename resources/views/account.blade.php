@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="main-content">
        <h2>My Account</h2>
        <p>Welcome, {{ auth()->user()->name }}</p>
        <p>Navigate your way through the menu.</p>
    </div>
@endsection
