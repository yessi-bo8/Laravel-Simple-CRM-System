@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
<div class="form-container">
<h2>Register</h2>
        <form id="register-form">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
            </div>
            <button type="submit">Register</button>
        </form>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection