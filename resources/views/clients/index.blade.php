@extends('layouts.app')

@section('title', 'Clients')

@section('content')
    <h1>Clients</h1>
    <ul>
        @foreach ($clients as $client)
            <li>{{ $client->first_name }} {{ $client->last_name }} - {{ $client->email }}</li>
        @endforeach
    </ul>
@endsection
