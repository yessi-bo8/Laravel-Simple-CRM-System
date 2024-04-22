@extends('layouts.app')
@section('banner', 'Update Client')
@section('content')
<div class="form-container" >
    <div>
    <form action="{{ route('clients.update', ['client'=>$client]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        @if ($client->profile_picture)
        <img id="profile_picture_preview" src="{{ Storage::url($client->profile_picture) }}" alt="Current Profile Picture" class="profile-picture">
        @else
            <p>No profile picture uploaded.</p>
        @endif

        <label for="profile_picture">Add new profile picture:</label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/png, image/jpeg">

        @error('profile_picture')
            <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror

        <label for="name">Name:</label>
        <input name="name" type="text" id="clientName" value="{{ $client->name }}" required>
        @error('name')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror
        <br />

        <label for="email">Email:</label>
        <input name="email" type="email" id="clientEmail" value="{{ $client->email }}" required>
        @error('email')
                <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror
        <br />

        <label for="company">Company:</label>
        <input name="company" type="text" id="clientCompany" value="{{ $client->company }}" required>
        @error('company')
            <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror
        <br />


        <label for="vat">VAT:</label>
        <input name="vat" type="text" id="clientVat" value="{{ $client->vat }}" required>
        @error('vat')
            <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror
        <br />

        <label for="address">Address:</label>
        <input name="address" type="address" id="clientAddress" value="{{ $client->address }}" required>
        @error('address')
            <div class="alert alert-danger form_danger">{{ $message }}</div>
        @enderror
        <br />

        <button type="submit">Submit</button>
    </form>
    </div>
</div>
@endsection

