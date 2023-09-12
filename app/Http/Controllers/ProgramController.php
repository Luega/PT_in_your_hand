<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Exercise;
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
        $request->validate([
            'title' => 'required|string|max:255',
            'period_of_time' => 'required|date',
            'goal' => 'required|string|max:255',
        ]);
        
        $program = new Program($request->all());
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

        $request->validate([
            'title' => 'required|string|max:255',
            'period_of_time' => 'required|date',
            'goal' => 'required|string|max:255',
        ]);

        $program->update($request->all());

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

    public function attachExercise($id, Request $request)
    {
       $program = Program::find($id);
        if (!$program) {
            return response()->json(['message' => 'Program not found'], 404);
        }

        $request->validate([
            'exercise_ids' => 'required|array',
            'exercise_ids.*' => 'required|exists:exercises,id',
        ]);

        $program->exercises()->attach($request->input('exercise_ids'));
        
        return response()->json(['message' => 'Exercises attached to program']);
    }

    public function detachExercise($id, Request $request)
    {
       $program = Program::find($id);
        if (!$program) {
            return response()->json(['message' => 'Program not found'], 404);
        }

        $request->validate([
            'exercise_ids' => 'required|array',
            'exercise_ids.*' => 'required|exists:exercises,id',
        ]);

        $program->exercises()->detach($request->input('exercise_ids'));
        
        return response()->json(['message' => 'Exercises attached to program']);
    }
}
