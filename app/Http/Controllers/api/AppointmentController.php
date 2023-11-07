<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Resources\AppointmentResource;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $appointments = Appointment::whereHas('user', function ($query) {
            })
            ->with('user')
            ->whereHas('lawyer_time', function ($query) {
            })
            ->with('lawyer_time')
            ->get();

        return AppointmentResource::collection($appointments);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data_appointment = [
            'payment_method'   => $request['payment_method'],
            'appointment_date' => $request['appointment_date'],
            'client_name'      => $request['client_name'],
            'client_phone'     => $request['client_phone'],
            'client_email'     => $request['client_email'],
            'user_id'          => $request['user_id'],
            'lawyer_time_id'   => $request['lawyer_time_id'],
            
        ];

        $appointment = Appointment::create($data_appointment);

        return (new AppointmentResource($appointment))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
    public function lawyer_appointments(Request $request)
    {
        $lawyer_id = $request->input('lawyer_id');

        $appointments = Appointment::whereHas('user', function ($query) {
            })
            ->with('user')
            ->whereHas('lawyer_time', function ($query) {
            })
            ->with('lawyer_time')
            ->whereHas('lawyer_time.lawyer', function ($query) use ($lawyer_id) {
                $query->where('id', $lawyer_id);
            })
            ->with('lawyer_time.lawyer')
            
            ->get();

        return AppointmentResource::collection($appointments);

    }
    
}
