@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
<div>
    <h2>Login</h2>
    <form id="login-form">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit">Login</button> <!-- Remove the onclick attribute -->
    </form>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
