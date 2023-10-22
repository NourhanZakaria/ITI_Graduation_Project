<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use App\Http\Resources\LawyerResource;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $lawyers = Lawyer::all();
        return LawyerResource::collection($lawyers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lawyer $lawyer)
    {
        //
        $lawyer=DB::table('lawyers')
                    ->join('lawyer_time', 'lawyers.id', '=', 'lawyer_time.lawyer_id')
                    ->join('appointments', 'lawyer_time.id', '=', 'appointments.lawyerTime_id')
                    ->join('users', 'appointments.user_id', '=', 'users.id')
                    ->join('reviews', 'appointments.id', '=', 'reviews.appointment_id')
                    ->where('lawyers.id', '=', $lawyer->id)
                    ->select('reviews.rate','reviews.comment','reviews.created_at','lawyer_time.startHour','lawyer_time.endHour','lawyer_time.day')
                    ->get();

    
         return new LawyerResource($lawyer);
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
