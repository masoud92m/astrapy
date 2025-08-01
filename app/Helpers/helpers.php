<?php

use Carbon\Carbon;

if (!function_exists('jsonResponse')) {
    function jsonResponse(bool $status = true, null|string|array $message = null, int $statusCode = 200, $data = null, $errors = null): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            compact('status', 'message', 'data', 'errors')
            , $statusCode);
    }
}

if (!function_exists('checkValidator')) {
    function checkValidator($validator): bool|array
    {
        if ($validator->fails()) {
            $messages = [];
            foreach ($validator->errors()->toArray() as $key => $item) {
                $messages[$key] = $item[0];
            }
            return $messages;
        }
        return false;
    }
}

if (!function_exists('fa2en')) {
    function fa2en($string): string
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($persianNumbers, $englishNumbers, $string);
    }
}

if (!function_exists('hasSubscription')) {
    function hasSubscription($mobile = null)
    {
        if ($mobile) {
            $user = \App\Models\User::where('mobile', $mobile)->first();
        } else {
            $user = \Illuminate\Support\Facades\Auth::guard('api')->user();
        }
//        $user = \App\Models\User::find(1);
        if (!$user || !$user->subscription_started_at || !$user->subscription_expires_at) return false;
        $today = Carbon::today();
        $subscriptionStartDate = Carbon::parse($user->subscription_started_at)->startOfDay();
        $subscriptionEndDate = Carbon::parse($user->subscription_expires_at)->startOfDay();
        return $subscriptionStartDate->lessThanOrEqualTo($today) && $subscriptionEndDate->greaterThanOrEqualTo($today);
    }
}

if (!function_exists('getSubscriptionDay')) {
    function getSubscriptionDay($period = 28, $trial_days = 0)
    {
        if (\Illuminate\Support\Facades\Auth::guard('api')->check()) {
            $user = \Illuminate\Support\Facades\Auth::guard('api')->user();
            if ($user->subscription_started_at) {
                $started_at = Carbon::parse($user->subscription_started_at);
                $day = (int)$started_at->startOfDay()->diffInDays(Carbon::today());
                $subscription_day = ($day % $period) + 1;

                if (hasSubscription()) {
                    return $subscription_day;
                } elseif ($trial_days > 0) {
                    return min($trial_days, $subscription_day);
                }
            }
        }
        return 1;
    }
}

if (!function_exists('getTodayActivities')) {
    function getTodayActivities()
    {
        if (\Illuminate\Support\Facades\Auth::guard('api')->check()) {
            $sections = \Illuminate\Support\Facades\DB::table('activities')
                ->select([
                    'section',
                    'text1',
                    'text2',
                    'text3',
                ])
                ->where('user_id', \Illuminate\Support\Facades\Auth::guard('api')->id())
                ->where(\Illuminate\Support\Facades\DB::raw('date(created_at)'), Carbon::today())
                ->get()
                ->keyBy('section')
                ->toArray();
            return $sections;
        }
        return [];
    }
}

if (!function_exists('todayActivityIsDone')) {
    function todayActivityIsDone($section)
    {
        return isset(gettodayActivities()[$section]);
    }
}
