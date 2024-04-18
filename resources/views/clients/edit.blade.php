@extends('layouts.app')
@section('content')
<div class="form-container" >
    <h1>Edit Client</h1>
    <div>
    <form action="{{ route('clients.update', ['client'=>$client]) }}" method="POST">
        @csrf
        @method('PATCH')
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

