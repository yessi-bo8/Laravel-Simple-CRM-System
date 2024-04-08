@extends('layouts.app')
@section('content')
<div class="container">
    <h1>New Project</h1>
    <div>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <label>Title:</label>
            <input type="text" name="title" value="title">
            <br />

            <label>Content:</label>
            <input type="textfield" name="content" value="content">
            <br />

            <button type="submit">Make new Project</button>
        </form>
    </div>
</div>
@endsection

