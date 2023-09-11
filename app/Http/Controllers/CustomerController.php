<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();

        return response()->json(['customers' => $customers], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'date_of_birth'=>'required',
            'gender'=>'required',
            'height'=>'required',
            'weight'=>'required',
            'user_id'=>'required',
        ]);

        $customer = new Customer();

        $customer->first_name = $request->input('first_name');
        $customer->last_name = $request->input('last_name');
        $customer->email = $request->input('email');
        $customer->date_of_birth = $request->input('date_of_birth');
        $customer->gender = $request->input('gender');
        $customer->height = $request->input('height');
        $customer->weight = $request->input('weight');
        $customer->user_id = $request->input('user_id');

        $customer->save();

        return response()->json(['customer' => $customer], 201);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($customer)
    {
        $customer = Customer::find($customer);

        return response()->json(['customer' => $customer], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customer)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'date_of_birth'=>'required',
            'gender'=>'required',
            'height'=>'required',
            'weight'=>'required',
            'user_id'=>'required',
        ]);

        $customer = Customer::find($customer);

        $customer->first_name = $request->input('first_name');
        $customer->last_name = $request->input('last_name');
        $customer->email = $request->input('email');
        $customer->date_of_birth = $request->input('date_of_birth');
        $customer->gender = $request->input('gender');
        $customer->height = $request->input('height');
        $customer->weight = $request->input('weight');
        $customer->user_id = $request->input('user_id');

        $customer->save();

        return response()->json(['customer' => $customer], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($customer)
    {
        $customer = Customer::find($customer);

        $customer->delete();

        return Response()->json('Customer deleted successfully', 200);
    }
}
