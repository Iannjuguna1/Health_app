<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Schedule an appointment
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
            'notes' => 'nullable|string',
        ]);

        try {
            $appointment = new Appointment();
            $appointment->client_id = $request->client_id;
            $appointment->user_id = $request->user_id;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->notes = $request->notes;
            $appointment->save();

            return response()->json(['message' => 'Appointment scheduled successfully', 'appointment' => $appointment]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to schedule appointment', 'details' => $e->getMessage()], 500);
        }
    }

    // View all appointments
    public function index()
    {
        try {
            $appointments = Appointment::with(['client', 'user'])->paginate(10);
            return response()->json($appointments);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve appointments', 'details' => $e->getMessage()], 500);
        }
    }

    // View a specific appointment
    public function show($id)
    {
        try {
            $appointment = Appointment::with(['client', 'user'])->findOrFail($id);
            return response()->json($appointment);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve appointment', 'details' => $e->getMessage()], 500);
        }
    }

    // Update an appointment
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'notes' => 'nullable|string',
        ]);

        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->notes = $request->notes;
            $appointment->save();

            return response()->json(['message' => 'Appointment updated successfully', 'appointment' => $appointment]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update appointment', 'details' => $e->getMessage()], 500);
        }
    }

    // Cancel an appointment
    public function destroy($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->delete();

            return response()->json(['message' => 'Appointment canceled successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to cancel appointment', 'details' => $e->getMessage()], 500);
        }
    }
}
