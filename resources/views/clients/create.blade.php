@extends('layouts.app')
@section('banner', 'Create Client')
@vite(['resources/js/app.js'])
@section('content')
<div class="form-container">
    <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
       
       <!-- Profile picture preview -->
<img id="profile_picture_preview" class="profile-picture" src="" alt="Profile Picture Preview">

<!-- Input for profile picture -->
<label for="profile_picture" class="picture-button">Add profile picture</label>
<input type="file" id="profile_picture" name="profile_picture" accept="image/png, image/jpeg" style="display: none;">

@error('profile_picture')
    <div class="alert alert-danger form_danger">{{ $message }}</div>
@enderror

        <label for="name">Name:</label>
        <input name="name" type="text" id="clientName" required>
        @error('name')
            <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror
        <br />

        <label for="email">Email:</label>
        <input name="email" type="email" id="clientEmail" required>
        @error('email')
            <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror
        <br />

        <label for="company">Company:</label>
        <input name="company" type="text" id="clientCompany" required>
        @error('company')
            <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror
        <br />

        <label for="vat">VAT:</label>
        <input name="vat" type="text" id="clientVat" required>
        @error('vat')
            <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror
        <br />

        <label for="address">Address:</label>
        <input name="address" type="address" id="clientAddress" required>
        @error('address')
            <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror
        <br />

        <button type="submit">Submit</button>
    </form>
</div>

@endsection
