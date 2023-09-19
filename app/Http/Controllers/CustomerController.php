<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Program;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
   public function index()
    {
        $user = auth()->user();
        $customers = $user->customers;
        return response()->json(['customers' => $customers], 200);
    }

    public function show($id)
    {
        $user = auth()->user();
        $customer = $user->customers->find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json(['customer' => $customer], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'date_of_birth' => 'required|date',
            'gender' => 'required|boolean',
            'height' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ]);

        $customer = new Customer($request->all());
        $customer->user_id = $request->user()->id;
        $customer->save();

        return response()->json(['customer' => $customer], 201);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $customer = $user->customers->find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'date_of_birth' => 'required|date',
            'gender' => 'required|boolean',
            'height' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ]);

        $customer->update($request->all());

        return response()->json(['customer' => $customer], 200);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $customer = $user->customers->find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted'], 204);
    }

    public function attachPrograms($id, Request $request)
    {
        $user = auth()->user();
        $customer = $user->customers->find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $request->validate([
            'program_ids' => 'required|array',
            'program_ids.*' => 'required|exists:programs,id',
        ]);

        foreach ($request->input('program_ids') as $programId) {
            if ($customer->programs()->where('program_id', $programId)->exists()) {
                return response()->json(['message' => 'Relationship already exists for program ID ' . $programId], 400);
            }
        }

        $customer->programs()->attach($request->input('program_ids'));
        
        return response()->json(['message' => 'Programs attached to customer']);
    }

    public function detachPrograms($id, Request $request)
    {
        $user = auth()->user();
        $customer = $user->customers->find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $request->validate([
            'program_ids' => 'required|array',
            'program_ids.*' => 'required|exists:programs,id',
        ]);

        foreach ($request->input('program_ids') as $programId) {
            if ($customer->programs()->where('program_id', $programId)->doesntExist()) {
                return response()->json(['message' => 'Relationship does not exists for program ID ' . $programId], 400);
            }
        }

        $customer->programs()->detach($request->input('program_ids'));
        
        return response()->json(['message' => 'Programs detached from customer']);
    }
}
