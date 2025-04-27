@extends('layouts.app')

@section('title', 'Programs')

@section('content')
    <h1>Programs</h1>
    <ul>
        @foreach ($programs as $program)
            <li>{{ $program->name }} - {{ $program->description }}</li>
        @endforeach
    </ul>
@endsection
