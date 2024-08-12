<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use Illuminate\Support\Facades\Auth;


class DivisionController extends Controller
{
    public function index(Request $request)
    {


     

        $divisions = Division::query();

        if ($request->has('name')) {
            $divisions->where('name', 'like', '%' . $request->name . '%');
        }
        
        $divisions = $divisions->select('division_id as id', 'name')->paginate(10);
       
        return response()->json([

          
            'status' => 'success',
            'message' => 'Divisions retrieved successfully',
            'data' => [
                'divisions' => $divisions->items(),
            ],
            'pagination' => [
                'current_page' => $divisions->currentPage(),
                'last_page' => $divisions->lastPage(),
                'per_page' => $divisions->perPage(),
                'total' => $divisions->total(),
                'next_page_url' => $divisions->nextPageUrl(),
                'prev_page_url' => $divisions->previousPageUrl(),
            ],
        ]);
    }
}