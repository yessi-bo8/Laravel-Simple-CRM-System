@extends('layouts.app')

@vite(['resources/js/app.js'])
@section('content')
<div class="form-container">
    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
            <input name="name" type="text" id="clientName" placeholder="Name">
            <input name="email" type="email" id="clientEmail" placeholder="Email" required>
            <input name="company" type="text" id="clientCompany" placeholder="Company" required>
            <input name="vat" type="text" id="clientVat" placeholder="vat" required>
            <input name="address" type="address" id="clientAddress" placeholder="address" required>
            <button type="submit">Submit</button>
    </form>
</div>

@endsection
