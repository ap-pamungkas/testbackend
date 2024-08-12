<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;


class EmployeeController extends Controller
{
    public function index(Request $request)
    {
  
        $name = $request->input('name');
        $division_name = $request->input('division_name');
    
        $query = Employee::with('division');
       
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
    
        if ($division_name) {
            $query->whereHas('division', function ($q) use ($division_name) {
                $q->where('name', 'like', '%' . $division_name . '%');
            });
        }
    
      
        $employees = $query->paginate(10);
    
  
        $formattedEmployees = collect($employees->items())->map(function ($employee) {
            return (object) [
                'id' => $employee->employee_id,
                'image' => $employee->image,
                'name' => $employee->name,
                'phone' => $employee->phone,
                'division' => [
                    'id' => $employee->division_id,
                    'name' => optional($employee->division)->name,
                ],
                'position' => $employee->position,
            ];
        });
    
        return response()->json([
            'status' => 'success',
            'message' => 'Employees retrieved successfully',
            'data' => [
                'employees' => $formattedEmployees,
            ],
            'pagination' => [
                'total' => $employees->total(),
                'per_page' => $employees->perPage(),
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'first_page_url' => $employees->url(1),
                'last_page_url' => $employees->url($employees->lastPage()),
                'next_page_url' => $employees->nextPageUrl(),
                'prev_page_url' => $employees->previousPageUrl(),
                'path' => $employees->path(),
                'from' => $employees->firstItem(),
                'to' => $employees->lastItem(),
            ]
        ]);
    }


    public function store(Request $request)
    {
        

        
      
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'division_id' => 'required', 
            'position' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

     
        $imagePath = $request->file('image')->store('employee_images', 'public');

        $employee = new Employee;

        $employee->name= $request->name;
        $employee->image= $imagePath;
        $employee->phone= $request->phone;
        $employee->division_id= $request->division_id;
        $employee->position= $request->position;


        $employee->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully',
        ], 201);
    }


    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        // Validasi data

     
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'division_id' => 'required|integer',
            'position' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }
    
        // Temukan karyawan
        $employee = Employee::find($id);
       
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found',
            ], 404);
        }
    

        if ($request->hasFile('image')) {
            if ($employee->image) {
                Storage::disk('public')->delete($employee->image);
            }
            $imagePath = $request->file('image')->store('employee_images', 'public');
            $employee->image = $imagePath;
        }
    
      
        $employee->name = $request->input('name');
        $employee->phone = $request->input('phone');
        $employee->division_id = $request->input('division_id');
        $employee->position = $request->input('position');
    
        $employee->save();

 
    
        return response()->json([
            'status' => 'success',
            'message' => 'Employee updated successfully',
        
        ], 200);
    }
    

    public function destroy($id)
    {
        
        $employee = Employee::where('employee_id', $id)->first();

        if ($employee) {
          
            $employee->delete();

            
            return response()->json([
                'status' => 'success',
                'message' => 'Employee successfully deleted.'
            ]);
        } else {
           
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found.'
            ]);
        }
    }
}

