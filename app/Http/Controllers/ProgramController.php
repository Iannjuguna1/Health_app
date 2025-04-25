<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    // Create a new program
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:programs,name',
        ]);

        try {
            $program = new Program();
            $program->name = $request->name;
            $program->description = $request->description ?? '';
            $program->save();

            return response()->json(['message' => 'Program created successfully', 'program' => $program]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create program', 'details' => $e->getMessage()], 500);
        }
    }

    // Update a program
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:programs,name,' . $id,
            'description' => 'nullable',
        ]);

        try {
            $program = Program::findOrFail($id);
            $program->name = $request->name;
            $program->description = $request->description ?? '';
            $program->save();

            return response()->json(['message' => 'Program updated successfully', 'program' => $program]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update program', 'details' => $e->getMessage()], 500);
        }
    }

    // Suspend a program
    public function suspend($id)
    {
        try {
            $program = Program::findOrFail($id);
            $program->status = 'suspended';
            $program->save();

            return response()->json(['message' => 'Program suspended successfully', 'program' => $program]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to suspend program', 'details' => $e->getMessage()], 500);
        }
    }
}
