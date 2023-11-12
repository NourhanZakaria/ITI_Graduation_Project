<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\NotificationResource;
class NotificationsController extends Controller
{
    public function  __construct (){
       // $this->middleware('auth:sanctum') ;
    }


    public function notifications()
    {
       // $user = Auth::user() ;
       // $user = User::findOrFail(3);
        //dd($user);
        
        $user=Auth::guard('sanctum')->user();
        $notifications = $user->notifications()->get();

        return NotificationResource::collection($notifications); 
        //return NotificationResource::sendResponse(200, "", $notifications);
    }
}
