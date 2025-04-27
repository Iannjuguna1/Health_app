<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //display form

    public function create()
{
    return view('clients.create'); // Render the Blade form
}

    // Register a new client
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|unique:clients,phone',
            'address' => 'nullable|string',
            'date_of_birth' => 'required|date',
        ]);

        try {
            $client = new Client();
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->gender = $request->gender;
            $client->email = $request->email;
            $client->phone = $request->phone;
            $client->address = $request->address;
            $client->date_of_birth = $request->date_of_birth;
            $client->save();

            // Return a 201 status code for successful creation
            return response()->json(['message' => 'Client registered successfully', 'client' => $client], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to register client', 'details' => $e->getMessage()], 500);
        }
    }

    // Update client information
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:clients,email,' . $id,
            'phone' => 'required|string|unique:clients,phone,' . $id,
            'address' => 'nullable|string',
            'date_of_birth' => 'required|date',
        ]);

        try {
            $client = Client::findOrFail($id);
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->gender = $request->gender;
            $client->email = $request->email;
            $client->phone = $request->phone;
            $client->address = $request->address;
            $client->date_of_birth = $request->date_of_birth;
            $client->save();

            return response()->json(['message' => 'Client updated successfully', 'client' => $client]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update client', 'details' => $e->getMessage()], 500);
        }
    }

    // Delete a client
    public function destroy($id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();

            return response()->json(['message' => 'Client deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete client', 'details' => $e->getMessage()], 500);
        }
    }

    // View a client's profile
    public function show($id)
    {
        try {
            $client = Client::with(['appointments', 'programs', 'users', 'notifications'])->findOrFail($id);

            return response()->json(['client' => $client]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve client profile', 'details' => $e->getMessage()], 500);
        }
    }

    // List all clients
    public function index()
    {
        $clients = Client::all(); // Fetch all clients
        return view('clients.index', compact('clients')); // Pass data to the view
    }
}
