@extends('layouts.app')
@section('content')
<div class="form-container" >
    <h1>New Project</h1>
    <div>
    <form id="project-form" method="POST" >
            @csrf
            <label>Title:</label>
            <input type="text" name="title">
            <br />

            <label for="description">Description:</label>
            <textarea name="description" rows="4" cols="50"></textarea>
            <br />

            <label>Date deadline:</label>
            <input type="date" name="event_date" value="{{ date('Y-m-d') }}">
            <br />

            <label for="client_name">Client:</label>
            <select name="client_name">
                <option value="">Select Client</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->name }}">{{ $client->name }}</option>
                @endforeach
            </select>
            </br>

            <select name="status">
                <option value="approved">approved</option>
                <option value="pending">pending</option>
                <option value="rejected">rejected</option>
            </select>
            </br >

            <button type="submit">Make new Project</button>
        </form>

        <!-- Modal container -->
   <!-- Modal container -->
   <div id="modal-container" class="modal-container">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <div id="message"></div>
            <button id="go-to-project" style="display: none;">Go to Project</button>
        </div>
    </div>

    </div>
    </div>
</div>
@endsection

