<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Program;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   public function index()
    {
        $customers = Customer::all();
        return response()->json(['customers' => $customers], 200);
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json(['customer' => $customer], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'date_of_birth' => 'required|date',
            'gender' => 'required|boolean',
            'height' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ]);

        $customer = new Customer($validatedData);
        $customer->user_id = 1; // SHOULD ADD AUTH USER ID
        $customer->save();

        return response()->json(['customer' => $customer], 201);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'date_of_birth' => 'required|date',
            'gender' => 'required|boolean',
            'height' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ]);

        $customer->update($validatedData);

        return response()->json(['customer' => $customer], 200);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted'], 204);
    }

    public function attachProgram(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'program_id' => 'required|exists:programs,id',
        ]);

        $customer = Customer::find($request->input('customer_id'));
        $program = Program::find($request->input('program_id'));

        $customer->programs()->attach($program->id);
        
        return response()->json(['message' => 'Program attached to customer']);
    }

    public function detachProgram(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'program_id' => 'required|exists:programs,id',
        ]);

        $customer = Customer::find($request->input('customer_id'));
        $program = Program::find($request->input('program_id'));

        $customer->programs()->detach($program->id);
        
        return response()->json(['message' => 'Program detached from customer']);
    }
}
