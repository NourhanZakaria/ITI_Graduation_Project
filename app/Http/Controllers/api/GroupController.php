<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups=Group::all();

        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$request['user_id']=Auth::id();  

        $group=Group::create($request->all());
        
        $group->user_id=Auth::guard('sanctum')->user();
        $group->save();
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        $user = User::findOrFail($userId);
        
        $groups = $user->user_createGroup;

        return new GroupResource($groups);

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        if($request['user_id']==Auth::Auth::guard('sanctum')->user()){

            $group->update($request->all());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        if($request['user_id']==Auth::Auth::guard('sanctum')->user()){
            $group->delete();
        }


    }
}
