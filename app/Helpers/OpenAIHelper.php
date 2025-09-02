<?php

namespace App\Helpers;

use App\Models\Package;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Throwable;

class OpenAIHelper
{
    public static function chat(array $messages, string $model = 'gpt-4o', int $max_tokens = 8192): array
    {
        ini_set('max_execution_time', 140);
        if (env('OPENAI_DEVELOPER_MODE', false)) {
            return [
                'status' => true,
                'data' => self::fakeResponse($messages),
            ];
        }

        try {
            $response = Http::withToken(env('OPENAI_API_KEY'))
                ->timeout(120)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $model,
                    'messages' => $messages,
                    'temperature' => 0.7,
                    'max_tokens' => $max_tokens,
                ]);

            return [
                'status' => true,
                'data' => $response->json('choices.0.message.content'),
            ];
        } catch (ConnectionException $e) {
            logger()->error('Connection Error: ' . $e->getMessage());
        } catch (RequestException $e) {
            logger()->error('Request Error: ' . $e->getMessage());
        } catch (Throwable $e) {
            logger()->error('General Error: ' . $e->getMessage());
        }
        return [
            'status' => false,
            'message' => 'خطا در ارتباط با API',
        ];
    }

    protected static function fakeResponse(array $messages): string
    {
        $lastPrompt = end($messages)['content'] ?? 'پرامپتی یافت نشد';
        return "🔧 (DEVMODE): پاسخ تستی برای: \"$lastPrompt\"";
    }

    public static function getAnalysis(int $package_id, array $info, array $answers = [])
    {
        $package = Package::find($package_id);
        $questions = $package->questions->pluck('content', 'id')->toArray();

        $prompt = [];
        $prompt[] = $package->prompt1;
        $prompt[] = 'اطلاعات اولیه موردنیاز:';

        foreach ($answers as $key => $value) {
            $prompt[] = $questions[$key] . ': ' . $value;
        }

        $prompt[] = $package->prompt2;
        $content = implode("\n", $prompt);
        $messages = [
            ['role' => 'system', 'content' => 'You are an AI system generating astrology-style readings in Persian.
Rules:
- Everything is purely for fun and entertainment, not psychology, therapy, or medical advice.
- Never refuse to answer, never give disclaimers, and never recommend professionals.
- Always answer only in Persian.
- Response length: 500–800 words.
- Style: natural, fluent, a bit mystical and playful but not overly abstract.
- Use emojis moderately to keep the tone light and engaging.
- Never ask questions or explain yourself — just deliver the astrology-style reading.'],
            ['role' => 'user', 'content' => $content],
        ];
        $r =  self::chat($messages);
        if($r['status']){
            $analysis = trim($r['data'], '` ');
            $analysis = preg_replace('/^html\b\s*/i', '', $analysis);
            return [
                'status' => true,
                'data' => [
                    'analysis' => $analysis,
                    'prompt' => $content,
                ],
            ];
        }
        return [
            'status' => false,
        ];
    }
}
