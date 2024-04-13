@extends('layouts.app')
@section('content')
<div class="form-containerr" >
    <h1>Edit Client</h1>
    <div>
    <form action="{{ route('clients.update', ['client'=>$client]) }}" method="POST">
        @csrf
        @method('PATCH')
        <label>Name:</label>
        <input name="name" type="text" id="clientName" value="{{ $client->name }}">

        <label>Email:</label>
        <input name="email" type="email" id="clientEmail" value="{{ $client->email }}" required>

        <label>Company:</label>
        <input name="company" type="text" id="clientCompany" value="{{ $client->company }}" required>
        
        <label>VAT:</label>
        <input name="vat" type="text" id="clientVat" value="{{ $client->vat }}" required>
        
        <label>Address:</label>
        <input name="address" type="address" id="clientAddress" value="{{ $client->address }}" required>
        </br>
        <button type="submit">Submit</button>
    </form>
    </div>
</div>
@if($errors->has('no_changes'))
    <div class="alert alert-error">
        {{ $errors->first('no_changes') }}
    </div>
@endif
@endsection

