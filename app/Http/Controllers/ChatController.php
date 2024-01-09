<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Auth;
use Kreait\Laravel\Firebase\Facades\Firebase;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function chat(Request $request)
    {
        $userInput = $request->input('message');
        // $userId=Auth::id();

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $userInput],
            ],
        ]);

        // $chatResponse = $response->choices[0]->message->content;

        // $data = [
        //     'userId' => $userId,
        //     'userInput' => $userInput,
        //     'chatResponse' => $chatResponse,
        //     'timestamp' => now(),
        // ];

        // // Wysłanie danych do Firebase
        // Firebase::database()->getReference('chats/' . $userId)->push($data);

        return redirect()->back()->with('response', $response->choices[0]->message->content);
    }


}
