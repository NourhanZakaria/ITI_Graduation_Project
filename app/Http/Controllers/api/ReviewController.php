<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $review=Review::all();
        
       return ReviewResource::collection($review);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        
        $review=Review::create($request->all());
       
        return $review;
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        // $review=DB::table('lawyers')->join('lawyer_time','lawyers.id','=','lawyer_time.lawyer_id')
        // ->join('appointments','lawyer_time.id','=','appointments.lawyerTime_id')
        // ->join('reviews','appointments.id','=','reviews.appointment_id')->get();

        

        
//         SELECT reviews.*
// FROM reviews
// JOIN appointments ON reviews.appointment_id = appointments.id
// JOIN lawyerTime ON appointments.lawyer_time_id = lawyerTime.id
// JOIN lawyer ON lawyerTime.lawyer_id = lawyer.id
// WHERE lawyer.id = [lawyer_id];


        //return new ReviewResource($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
