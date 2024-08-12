<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function login(Request $request){

        $user = User::all();
     return response()->json($user);
    }


    function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
           
            'name' => 'required|string|max:255',
       
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $user = User::find($id);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        
        

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully updated.',
       
        ]);
    }
}
