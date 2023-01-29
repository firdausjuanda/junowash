<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\ForgotPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\FlareClient\Api;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|max:255'
            ]);
            if (!$validator->fails()) {
                $verification_token = Str::random(40);
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'verification_token' => $verification_token,
                ]);
                $domain = URL::to('/');
                $data['name'] = $request->name;
                $data['email'] = $request->email;
                $data['url'] = $domain . '/api/auth/verify?token=' . $verification_token . '&i=' . $user->id;
                $data['verification_token'] = $verification_token;

                if (Mail::send('email/user-verification', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject('MotoWash - Email Verification for New User');
                })) {
                }
                return ApiFormatter::createApi('200', "Success", $user);
            } else {
                return ApiFormatter::createApi('400', "Failed", $validator->errors());
            }
        } catch (\Exception $e) {
            return ApiFormatter::createApi('400', "Failed: {$e->getMessage()}");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns',
        ]);
        if (!$validator->fails()) {
            $user = User::where('email', $request->email)->first();
            // $user = User::firstOrFail()->where('email', $request->email);
            if ($user !== null) {
                if ($user->active == 0) {
                    return ApiFormatter::createApi('400', 'Deactivated account!');
                }
                $passwordValidation = Hash::check($request->password, $user->password);
                if (!$passwordValidation) {
                    return ApiFormatter::createApi('400', 'Password is incorrect!');
                } else {
                    return ApiFormatter::createApi('200', 'Success', $user);
                }
            } else {
                return ApiFormatter::createApi('400', 'Email is not yet registered!');
            }
        } else {
            return ApiFormatter::createApi('400', 'Validation Error', $validator->errors());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $token = $request->get('token');
        $uid = $request->get('i');
        $date = Carbon::now()->format("Y-m-d H:i:s");
        $data = [
            'verification_token' => null,
            'active' => 1,
            'email_verified_at' => $date,
        ];
        $user = User::findOrFail($uid);

        if ($user != null && $user->verification_token == $token) {
            $user->update($data);
            return ApiFormatter::createApi('400', 'Success');
        } else {
            return ApiFormatter::createApi('400', 'Invalid token!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if ($user != null) {
            $token = Str::random(40);
            $url = URL::to('/');
            $data['email'] = $request->email;
            $data['name'] = $user->name;
            $data['url'] = $url . '/api/auth/reset-password?token=' . $token . '&i=' . $user->id;
            Mail::send('email/reset-password', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject('Reset Password');
            });
            ForgotPassword::create([
                'user_id' => $user->id,
                'token' => $token,
            ]);
        }
        return ApiFormatter::createApi('200', 'Email sent to your account if it\'s registered!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        $token = $request->get('token');
        $i = $request->get('i');
        $user = User::findOrFail($i);
        $token_data = ForgotPassword::where('token', '=', $token)->first();
        if ($token_data != null && $token_data->token == $token) {
            if ($request->password == $request->password_confirm) {
                $validator = Validator::make($request->all(), [
                    'password' => 'required|min:8|max:255',
                    'password_confirm' => 'required|min:8|max:255',
                ]);
                if (!$validator->fails()) {

                    $user->update([
                        'password' => Hash::make($request->password)
                    ]);
                    $token_data->delete();
                    return ApiFormatter::createApi('200', "Success");
                } else {
                    return ApiFormatter::createApi('400', "Failed", $validator->errors());
                }
            } else {
                return ApiFormatter::createApi('400', "Failed", ['message' => "Password is not matched!"]);
            }
        } else {
            return ApiFormatter::createApi('400', "Failed", ['message' => "Invalid Token!"]);
        }
    }
}
