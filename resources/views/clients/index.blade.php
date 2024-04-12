@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
<div class="client-containerr">
    <h1>All clients</h1>
    <a href="#" class="button" id="createClientButton">Create Client</a>
    @foreach ($clients as $index => $client)
    <div class='client-list'>
        <a href='#' class="client-details-link" data-client-id="{{$client->id}}">{{$client->name}}</a>
    </div>
    @endforeach
</div>
<div class="client-details">
        <!-- Project details will be dynamically updated here -->
</div>
<div class="form-container" style="display: none;">
    <form id="createClientForm" action="{{ route('clients.store') }}" method="POST">
        @csrf
            <input name="name" type="text" id="clientName" placeholder="Name" required>
            <input name="email" type="email" id="clientEmail" placeholder="Email" required>
            <input name="company" type="text" id="clientCompany" placeholder="Company" required>
            <input name="vat" type="text" id="clientVat" placeholder="vat" required>
            <input name="address" type="address" id="clientAddress" placeholder="address" required>
            <button type="submit">Submit</button>
    </form>
</div>

@endsection
