<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class employeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee=Employee::all();
        return response()->json(['data'=>$employee]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input=$request->validate([
            'name'=>'required',
            'email'=>'required'||'email',
            'password'=>'required'
        ]);
        $input['email']='Employee-'.$input['email'];
        Employee::create($input);
        return response()->json(['Message'=>' new Employee is added succuessfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee=Employee::findOrFail($id);
        return response()->json(['data'=>$employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input=$request->validate([
            'name'=>'required',
            'email'=>'required'||'email',
            'password'=>'required'
        ]);
        $employee=Employee::findOrFail($id);
        $employee->update($employee);
        return response()->json(['Message'=>'Employee is updated succuessfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee=Employee::findOrFail($id);
        $employee->delete();
        return response()->json(['Message'=>'Employee is deleted succuessfully']);
    }
}
