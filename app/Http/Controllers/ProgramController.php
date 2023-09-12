<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return response()->json(['programs' => $programs], 200);
    }

    public function show($id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json(['message' => 'Program not found'], 404);
        }

        return response()->json(['program' => $program], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'period_of_time' => 'required|date',
            'goal' => 'required|string|max:255',
        ]);
        
        $program = new Program($validatedData);
        $program->user_id = 1; // SHOULD ADD AUTH USER ID
        $program->save();

        return response()->json(['program' => $program], 201);
    }

    public function update(Request $request, $id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json(['message' => 'Program not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'period_of_time' => 'required|date',
            'goal' => 'required|string|max:255',
        ]);

        $program->update($validatedData);

        return response()->json(['program' => $program], 200);
    }

    public function destroy($id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json(['message' => 'Program not found'], 404);
        }

        $program->delete();

        return response()->json(['message' => 'Program deleted'], 204);
    }
}
