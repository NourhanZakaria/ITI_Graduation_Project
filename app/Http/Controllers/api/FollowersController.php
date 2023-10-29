<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use Illuminate\Support\Facades\DB;
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
    public function store(Request $request,$lawyerId)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show($lawyerId)
    {
        $followers=DB::table("users")
        ->join("user_follow_lawyer","users.id","=","user_follow_lawyer.user_id")
        ->join("lawyers",'user_follow_lawyer.lawyer_id',"=","lawyers.id")
        ->where('lawyers.id', '=', $lawyerId)
        ->select("users.name");

        $lawyer_id=Lawyer::find($id);

        if(!$lawyer_id)
          return response([],404);

        
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
