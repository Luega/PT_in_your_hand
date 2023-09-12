<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::all();
        return response()->json(['exercises' => $exercises], 200);
    }

    public function show($id)
    {
        $exercise = Exercise::find($id);

        if (!$exercise) {
            return response()->json(['message' => 'Exercise not found'], 404);
        }

        return response()->json(['exercise' => $exercise], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'muscles_involved' => 'required|string|max:255',
            'repetitions' => 'required|integer|min:0',
            'series' => 'required|integer|min:0',
            'time_under_work' => 'required|integer|min:0',
            'time_of_rest' => 'required|integer|min:0',
        ]);

        $exercise = Exercise::create($validatedData);

        return response()->json(['exercise' => $exercise], 201);
    }

    public function update(Request $request, $id)
    {
        $exercise = Exercise::find($id);

        if (!$exercise) {
            return response()->json(['message' => 'Exercise not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'muscles_involved' => 'required|string|max:255',
            'repetitions' => 'required|integer|min:0',
            'series' => 'required|integer|min:0',
            'time_under_work' => 'required|integer|min:0',
            'time_of_rest' => 'required|integer|min:0',
        ]);

        $exercise->update($validatedData);

        return response()->json(['exercise' => $exercise], 200);
    }

    public function destroy($id)
    {
        $exercise = Exercise::find($id);

        if (!$exercise) {
            return response()->json(['message' => 'Exercise not found'], 404);
        }

        $exercise->delete();

        return response()->json(['message' => 'Exercise deleted'], 204);
    }
}
