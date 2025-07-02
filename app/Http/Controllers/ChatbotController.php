<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    //
    public function callAIChat()
    {
        $url = 'https://openrouter.ai/api/v1/chat/completions';
        $token = 'Bearer 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';
        $response = Http::withHeaders([
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ])->post($url, [
            "model" => "openrouter/cypher-alpha:free",
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Tư vấn cho tôi một món ăn phù hợp khi trời lạnh'
                ],
            ],
        ]);

        if ($response->successful()) {
            return response()->json([
                'status' => true,
                'data' => $response->json(),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Gọi AI thất bại',
            'error' => $response->body(),
        ], $response->status());
    }
}
