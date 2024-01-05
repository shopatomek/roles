<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function chat(Request $request)
    {
        $userInput = $request->input('message');

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $userInput],
            ],
        ]);

        return redirect()->back()->with('response', $response->choices[0]->message->content);
    }
}
