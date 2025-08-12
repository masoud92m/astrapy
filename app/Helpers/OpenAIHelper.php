<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class OpenAIHelper
{
    public static function chat(array $messages, string $model = 'gpt-3.5-turbo'): string
    {
        if (env('OPENAI_DEVELOPER_MODE', false)) {
            return self::fakeResponse($messages);
        }

        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.7,
            ]);

        return $response->json('choices.0.message.content');
    }

    protected static function fakeResponse(array $messages): string
    {
        $lastPrompt = end($messages)['content'] ?? 'پرامپتی یافت نشد';
        return "🔧 (DEVMODE): پاسخ تستی برای: \"$lastPrompt\"";
    }
}
