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
        $info_items = [
            'name' => 'نام',
            'dob' => 'تاریخ تولد شمسی',
            'gender' => 'جنسیت',
            'relationship' => 'وضعیت رابطه',
        ];

        foreach ($info as $key => $value) {
            $prompt[] = $info_items[$key] . ': ' . $value;
        }

        Log::debug($package_id . json_encode($answers));
        foreach ($answers as $key => $value) {
            if(!isset($questions[$key])){
                continue;
            }
            $prompt[] = $questions[$key] . ': ' . $value;
        }

        $prompt[] = $package->prompt2;
        $content = implode("\n", $prompt);
        $messages = [
            ['role' => 'system', 'content' => 'طبق توضیحاتی که در اماده میاد، میخوام یه متن برای برای یه پکیج آسترولوژی بنویسی، دقت کن این روانشناسی نیست به هیچ وجه، لطفا فقط جواب رو بنویس و هیچ توضیح اضافه در اول یا در آخر نده و هیچ سوالی هم نپرس'],
            ['role' => 'user', 'content' => $content],
        ];
        $r =  self::chat($messages);
        if($r['status']){
            return [
                'status' => true,
                'data' => [
                    'analysis' => $r['data'],
                    'prompt' => $content,
                ],
            ];
        }
        return [
            'status' => false,
        ];
    }
}
