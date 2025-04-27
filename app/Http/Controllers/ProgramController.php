<?php
// filepath: c:\xampp\htdocs\Health_app\app\Http\Controllers\ProgramController.php
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
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,suspended', // Validate status
        ]);

        try {
            // Default status to 'active' if not provided
            $programData = $request->only(['name', 'description', 'status']);
            $programData['status'] = $programData['status'] ?? 'active';

            $program = Program::create($programData);

            // Ensure the response includes the status field
            return response()->json(['message' => 'Program created successfully', 'program' => $program], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create program', 'details' => $e->getMessage()], 500);
        }
    }

    // Update a program
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:programs,name,' . $id,
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,suspended', // Validate status
        ]);

        try {
            $program = Program::findOrFail($id);
            $program->update($request->only(['name', 'description', 'status']));

            return response()->json(['message' => 'Program updated successfully', 'program' => $program], 200);
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

            return response()->json(['message' => 'Program suspended successfully', 'program' => $program], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to suspend program', 'details' => $e->getMessage()], 500);
        }
    }

    //list all programs:API
    public function index()
    {
        try {
            $programs = Program::all();

            // Ensure the response structure matches the test expectations
            return response()->json($programs, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve programs', 'details' => $e->getMessage()], 500);
        }
    }

    // Web: Render Blade view
public function indexView()
{
    try {
        $programs = Program::all();

        return view('programs.index', compact('programs')); // Pass data to the view
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Failed to retrieve programs']);
    }
}
}
