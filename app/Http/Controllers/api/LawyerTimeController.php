<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use App\Http\Resources\LawyerTimeResource;
use App\Http\Resources\LawyerResource;
use Illuminate\Support\Facades\DB;
class LawyerTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $lawyer=Lawyer::all();
        // dd($lawyer);
        
        //return LawyerResource::collection($lawyer);
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
         $lawyers=DB::table('lawyers')
        ->join('lawyer_time', 'lawyers.id', '=', 'lawyer_time.lawyer_id')
        ->where('lawyers.id', '=', $lawyer->id)
        ->select('lawyer_time.startHour','lawyer_time.endHour','lawyer_time.day')
        ->get();

        //dd($lawyer->lawyerTime);
       // return $lawyer->lawyerTime;

      // $lawyer = Lawyer::with('lawyerTime')->get();
      // dd($lawyer);
        return new LawyerTimeResource($lawyers);
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
