<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Program;
use App\Models\ProgramLog;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Enroll a client into one or more programs
    public function enroll(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'program_ids' => 'required|array',
            'program_ids.*' => 'exists:programs,id',
        ]);

        try {
            $client = Client::findOrFail($request->client_id);

            // Check for already enrolled programs
            $alreadyEnrolled = $client->programs()->whereIn('id', $request->program_ids)->pluck('id')->toArray();
            if (!empty($alreadyEnrolled)) {
                return response()->json([
                    'error' => 'Client is already enrolled in some programs',
                    'already_enrolled_programs' => $alreadyEnrolled,
                ], 400);
            }

            // Attach multiple programs
            $client->programs()->syncWithoutDetaching($request->program_ids);

            // Log the enrollment
            foreach ($request->program_ids as $programId) {
                ProgramLog::create([
                    'client_id' => $client->id,
                    'program_id' => $programId,
                    'action' => 'enrolled',
                    'log_entry' => "Client {$client->id} enrolled in program {$programId}",
                ]);
            }

            // Return the updated list of programs
            $enrolledPrograms = $client->programs;

            return response()->json([
                'message' => 'Client enrolled in programs successfully',
                'enrolled_programs' => $enrolledPrograms,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to enroll client in programs', 'details' => $e->getMessage()], 500);
        }
    }

    // Unenroll a client from one or more programs
    public function unenroll(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'program_ids' => 'required|array',
            'program_ids.*' => 'exists:programs,id',
        ]);

        try {
            $client = Client::findOrFail($request->client_id);

            // Detach programs
            $client->programs()->detach($request->program_ids);

            // Log the unenrollment
            foreach ($request->program_ids as $programId) {
                ProgramLog::create([
                    'client_id' => $client->id,
                    'program_id' => $programId,
                    'action' => 'unenrolled',
                    'log_entry' => "Client {$client->id} unenrolled from program {$programId}",
                ]);
            }

            return response()->json(['message' => 'Client unenrolled from programs successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to unenroll client from programs', 'details' => $e->getMessage()], 500);
        }
    }
}
