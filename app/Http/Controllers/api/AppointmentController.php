<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\AppointmentResource;
use App\Notifications\AppointmentReminder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Events\Order;
use Notifiable, SnoozeNotifiable;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $appointments = Appointment::whereHas('user', function ($query) {
        })
            ->with('user')
            ->whereHas('lawyer_time', function ($query) {
            })
            ->with('lawyer_time')
            ->whereHas('lawyer_time.lawyer', function ($query) {
            })
            ->with('lawyer_time.lawyer')
            ->get();

        //    /*    
        //         $tomorrow = now()->addDay();
        //         $tomorrowInString = now()->addDay()->toDateString();

        //         $notifications = Appointment::where('appointment_date', $tomorrowInString)
        //             //->select('appointment_date','user_id')
        //             ->whereHas('user', function ($query) {
        //             })
        //             ->with('user')
        //             ->whereHas('lawyer_time', function ($query) {
        //             })
        //             ->with('lawyer_time')
        //             ->whereHas('lawyer_time.lawyer', function ($query) {
        //             })
        //             ->with('lawyer_time.lawyer')

        //             ->get();

        // dd($notifications);


        // foreach($notifications as $notification)
        // {
        //     $not_day = Carbon::parse($notification->appointment_date);
        //     $sendAt = $not_day->subDay()->toDateString();
        //     //dd($sendAt);
        //     //Auth::user()->notifyAt(new AppointmentReminder(), $sendAt);
        //     $user_id = $notification->user->id;
        //     $lawyer_id = $notification->lawyer_time->lawyer->id;
        //     $user = $notification->user;
        //    // dd($user);
        //     /*
        //     $user = User::where('id', $notification->user_id)
        //                 ->select('email')
        //                 ->get();
        //                 */
        //    // $data = [$sendAt,$user_id,$lawyer_id];            
        //     Notification::send($user,new AppointmentReminder($sendAt,$user_id,$lawyer_id));


        // }














        //         foreach ($notifications as $notification) {
        //             // Send reminder notification to the user
        //             $user = $notification->user_id;

        //             // Send reminder notification to the lawyer
        //             //$lawyer = $notification->lawyer;

        //             // Send notifications to the user and lawyer using your preferred notification method (email, SMS, etc.)
        //             // Example: using Laravel's Notification system to send an email
        //             //$user->notify(new Appointment_reminder($notification));
        //            // $lawyer->notify(new Appointment_reminder($notification));

        //           // Notification::send($user,new Appointment_reminder($notification));
        //         }
        //         */

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

        // Event Notification
        // $appointment_date = $appointment->appointment_date;
        // $appointment_date = $appointment_date->toDateString();
        $appointment_date = Carbon::parse($appointment->appointment_date);

        $user = $appointment->user;
        $lawyer = $appointment->lawyer_time->lawyer->user;
        //return $user;
        //return $lawyer;
        //return  $appointment_date;

        // event(new Order($lawyer,$user));

        $user->notifyAt(new AppointmentReminder($appointment), $appointment_date);
        $lawyer->notifyAt(new AppointmentReminder($appointment), $appointment_date);
        // Notification::send($user->email,new AppointmentReminder($appointment), $appointment_date);


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
        if ($appointment->appointment_date && $appointment->appointment_date <= now()->toDateString()) {
            return response()->json(['message' => 'This appointment cannot be updated as its updating date has passed.'], 422);
        }
        $appointment->update($request->all());
        return new AppointmentResource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
        if ($appointment->appointment_date && $appointment->appointment_date <= now()->toDateString()) {
            return response()->json(['message' => 'This appointment cannot be deleted as its destroying date has passed.'], 422);
        }
        $appointment->delete();
        return response("Deleted", 204);
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
