<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $programs = $user->programs;
        return response()->json(['programs' => $programs], 200);
    }

    public function show($id)
    {
        $user = auth()->user();
        $program = $user->programs->find($id);

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
        $program->user_id = $request->user()->id; 
        $program->save();

        return response()->json(['program' => $program], 201);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $program = $user->programs->find($id);

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
        $user = auth()->user();
        $program = $user->programs->find($id);

        if (!$program) {
            return response()->json(['message' => 'Program not found'], 404);
        }

        $program->delete();

        return response()->json(['message' => 'Program deleted'], 204);
    }

    public function attachExercises($id, Request $request)
    {
        $user = auth()->user();
        $program = $user->programs->find($id);
        if (!$program) {
            return response()->json(['message' => 'Program not found'], 404);
        }

        $request->validate([
            'exercise_ids' => 'required|array',
            'exercise_ids.*' => 'required|exists:exercises,id',
        ]);

        foreach ($request->input('exercise_ids') as $exerciseId) {
            if ($program->exercises()->where('exercise_id', $exerciseId)->exists()) {
                return response()->json(['message' => 'Relationship already exists for program ID ' . $exerciseId], 400);
            }
        }

        $program->exercises()->attach($request->input('exercise_ids'));
        
        return response()->json(['message' => 'Exercises attached to program']);
    }

    public function detachExercises($id, Request $request)
    {
        $user = auth()->user();
        $program = $user->programs->find($id);
        if (!$program) {
            return response()->json(['message' => 'Program not found'], 404);
        }

        $request->validate([
            'exercise_ids' => 'required|array',
            'exercise_ids.*' => 'required|exists:exercises,id',
        ]);

        foreach ($request->input('exercise_ids') as $exerciseId) {
            if ($program->exercises()->where('exercise_id', $exerciseId)->doesntExist()) {
                return response()->json(['message' => 'Relationship does not exists for program ID ' . $exerciseId], 400);
            }
        }

        $program->exercises()->detach($request->input('exercise_ids'));
        
        return response()->json(['message' => 'Exercises detached from program']);
    }
}
