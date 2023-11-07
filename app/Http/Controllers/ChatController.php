<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string'
        ]);

        // Save the message to the database
        $message = new ChatMessage();
        $message->sender_id = $request->input('sender_id');
        $message->receiver_id = $request->input('receiver_id');
        $message->message = $data['message'];
        $message->save();

        // Trigger the event using Pusher
        $pusher = new \Pusher\Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'useTLS' => true
            ]
        );

        $pusher->trigger(
            'private-chat-' . $request->input('receiver_id'),
            'message',
            ['message' => $data['message']]
        );

        return response()->json(['message' => 'Message sent']);
    }
}
