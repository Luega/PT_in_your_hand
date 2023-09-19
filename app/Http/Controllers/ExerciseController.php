<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $exercises = $user->exercises;
        return response()->json(['exercises' => $exercises], 200);
    }

    public function show($id)
    {
        $user = auth()->user();
        $exercise = $user->exercises->find($id);

        if (!$exercise) {
            return response()->json(['message' => 'Exercise not found'], 404);
        }

        return response()->json(['exercise' => $exercise], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'muscles_involved' => 'required|string|max:255',
            'repetitions' => 'required|integer|min:0',
            'series' => 'required|integer|min:0',
            'time_under_work' => 'required|integer|min:0',
            'time_of_rest' => 'required|integer|min:0',
        ]);

        $exercise = new Exercise($request->all());
        $exercise->user_id = $request->user()->id;
        $exercise->save();

        return response()->json(['exercise' => $exercise], 201);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $exercise = $user->exercises->find($id);

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
        $user = auth()->user();
        $exercise = $user->exercises->find($id);

        if (!$exercise) {
            return response()->json(['message' => 'Exercise not found'], 404);
        }

        $exercise->delete();

        return response()->json(['message' => 'Exercise deleted'], 204);
    }
}
