<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\ChatEvent;
use App\Models\Message;

class ChatController extends Controller
{
    public function store($user_id, Request $request)
    {
        dd(Auth::guard('sanctum')->user());
        // Validate the request data
        $validatedData = $request->validate([
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'message' => 'required',
        ]);

        // Create a new chat message
        $chat = new Message();
        $chat->sender_id = $validatedData['sender_id'];
        $chat->receiver_id = $validatedData['receiver_id'];
        $chat->message = $validatedData['message'];
        $chat->save();

        // Trigger the chat event
        event(new ChatEvent($chat));
        // \broadcast(new ChatEvent($validatedData['receiver_id'], $validatedData['message']));

        // Return a response
        return response()->json(['message' => 'Chat message sent successfully']);
    }


    public function getChatHistory($receiverId, Request $request)
    {
        // $senderId = $request->query('sender_id');
        // $receiverId = $request->query('receiver_id');

        // $messages = Message::where('sender_id', $senderId)
        //     ->where('receiver_id', $receiverId)
        //     ->get();

        // return response()->json($messages);
        dd(Auth::guard('sanctum')->user());
        $messages = Message::where(function ($query) {
            $query->where('receiver_id', 2)
                ->where('sender_id', 5);
        })
            ->orWhere(function ($query) {
                $query->where('receiver_id', 5)
                    ->where('sender_id', 2);
            })
            ->get();

        return response()->json($messages);
    }
}
