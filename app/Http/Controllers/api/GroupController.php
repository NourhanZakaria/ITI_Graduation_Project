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
        //dd(Auth::guard('sanctum')->user()->id);
        $group=new Group;
        $group->user_id=Auth::guard('sanctum')->user()->id;
        $group->name=$request->name;
             
        $group->save();
      
       // return $group;
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        
        return new GroupResource($group);
        
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $isAdmin=Auth::guard('sanctum')->user()->role;
       
        if($group->user_id==Auth::guard('sanctum')->user()->id||$isAdmin=="admin")
         { 
        
            $group->update($request->all());
            return $group;
         }
        else{
            return response([], 401);
         }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $isAdmin=Auth::guard('sanctum')->user()->role;
        if($group->user_id==Auth::guard('sanctum')->user()->id||$isAdmin=="admin")
         { 
        
            $group->delete();
            
         }
        else{
            return response([], 401);
         }

    }


  
}
