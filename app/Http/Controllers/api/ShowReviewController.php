<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\LawyerResource;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class ShowReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //     $review=Review::all();
    //    return $review;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

          
        $validator = Validator::make($request->all(), [
            "rate"=>"min:1|max:5"
        ]);
     
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $review=Review::create($request->all());
          return $review;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lawyer=DB::table('lawyers')
        ->join('lawyer_time', 'lawyers.id', '=', 'lawyer_time.lawyer_id')
        ->join('appointments', 'lawyer_time.id', '=', 'appointments.lawyerTime_id')
        ->join('users', 'appointments.user_id', '=', 'users.id')
        ->join('reviews', 'appointments.id', '=', 'reviews.appointment_id')
        ->where('lawyers.id', '=', $id)
        ->select('reviews.rate','reviews.comment','reviews.created_at')
        ->get();
 
        $lawyer_id=Lawyer::find($id);

        if(!$lawyer_id)
          return response([],404);
  
        
        return new ReviewResource($lawyer);
         //return $lawyer;
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
