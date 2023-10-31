<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\FollowersResource;
class FollowersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $followers=new Follower;
        $followers->lawyer_id=$request->lawyer_id;
        $followers->user_id=Auth::guard('sanctum')->user()->id;

        $followers->save();

        return $followers;

    }

    /**
     * Display the specified resource.
     */
    public function show($lawyerId)
    {
        // $followers=DB::table("users")
        // ->join("user_follow_lawyer","users.id","=","user_follow_lawyer.user_id")
        // ->join("lawyers",'user_follow_lawyer.lawyer_id',"=","lawyers.id")
        // ->where('lawyers.id', '=', $lawyerId)
        // ->select("users.name","users.image");

        $lawyer_id=Lawyer::find($lawyerId);

        
        if(!$lawyer_id)
          return response([],404);

       $lawyers=User::all();
       dd($lawyers->follow);
       //if(Auth::guard('sanctum')->user()->id==)

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lawyer $lawyer)
    {
        //
    }
}
