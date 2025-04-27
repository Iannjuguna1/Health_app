@extends('layouts.app')

@section('title', 'Add Program')

@section('content')
    <h1>Add New Program</h1>
    <form action="/programs" method="POST">
        @csrf
        <label for="name">Program Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description"></textarea>
        <br>
        <button type="submit">Add Program</button>
    </form>
@endsection
