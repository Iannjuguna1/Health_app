{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Client Profile')

@section('content')
    <h1>Client Profile</h1>
    <p><strong>Name:</strong> {{ $client->first_name }} {{ $client->last_name }}</p>
    <p><strong>Email:</strong> {{ $client->email }}</p>
    <p><strong>Phone:</strong> {{ $client->phone }}</p>
    <p><strong>Address:</strong> {{ $client->address }}</p>
    <p><strong>Date of Birth:</strong> {{ $client->date_of_birth }}</p>
@endsection
