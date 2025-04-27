@extends('layouts.app')

@section('title', 'Enroll Client')

@section('content')
    <h1>Enroll Client in Programs</h1>
    <form action="/enrollments" method="POST">
        @csrf
        <label for="client_id">Select Client:</label>
        <select name="client_id" required>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
            @endforeach
        </select>
        <br>
        <label for="program_ids">Select Programs:</label>
        <select name="program_ids[]" multiple required>
            @foreach ($programs as $program)
                <option value="{{ $program->id }}">{{ $program->name }}</option>
            @endforeach
        </select>
        <br>
        <button type="submit">Enroll</button>
    </form>
@endsection
