<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::all();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name"=>"unique:users|required|min:3",
            "email"=>['unique:users','required','email',function ($attribute, $value, $fail) {
                if (!str_contains($value, '.com')) {
                    $fail('The '.$attribute.' must include ".com".');
                }
            }],
            "phone"=>"unique:users|required",
            "password"=>"unique:users|required|min:8"

        ]);
     
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user=User::create($request->all());
        //return $user;
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
        $validator = Validator::make($request->all(), [
            "name"=>"required|min:3",
            "email"=>['required','email',function ($attribute, $value, $fail) {
                if (!str_contains($value, '.com')) {
                    $fail('The '.$attribute.' must include ".com".');
                }
            }],
            "phone"=>"required",
            "password"=>"required|min:8"

        ]);
     
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

       $users=$user->update($request->all());
       //return new UserResource($users);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        //return "user deleted";
    }
}
