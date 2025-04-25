<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Register a new client
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:clients,email',
        ]);

        try {
            $client = new Client();
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->email = $request->email;
            $client->save();

            return response()->json(['message' => 'Client registered successfully', 'client' => $client]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to register client', 'details' => $e->getMessage()], 500);
        }
    }

    // Update client information
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:clients,email,' . $id,
        ]);

        try {
            $client = Client::findOrFail($id);
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->email = $request->email;
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
}
