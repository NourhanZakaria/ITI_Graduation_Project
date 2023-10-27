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
        $lawyer=DB::table('lawyers')
                    ->join('lawyer_times', 'lawyers.id', '=', 'lawyer_times.lawyer_id')
                    ->join('appointments', 'lawyer_times.id', '=', 'appointments.lawyer_time_id')
                    ->join('users', 'appointments.user_id', '=', 'users.id')
                    ->join('reviews', 'appointments.id', '=', 'reviews.appointment_id')
                    ->where('lawyers.id', '=', $id)
                    ->select('reviews.rate','reviews.comment','reviews.created_at')
                    ->get();
        return new ReviewResource($review);
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
