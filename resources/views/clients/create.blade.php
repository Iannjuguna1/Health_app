@extends('layouts.app')

@section('title', 'Add Client')

@section('content')
    <h1>Add New Client</h1>
    <form action="{{ route('clients.store') }}" method="POST"> <!-- Use the named route -->
        @csrf
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required>
        <br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" required>
        <br>
        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <br>
        <label for="address">Address:</label>
        <textarea name="address"></textarea>
        <br>
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" required>
        <br>
        <button type="submit">Add Client</button>
    </form>
@endsection
