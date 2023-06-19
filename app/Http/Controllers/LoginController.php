<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class LoginController extends Controller
{
    public function userRegistration(Request $request)
    {
        $validate = validator::make($request->all(), [
            'firstName' => 'required|min:5|max:255',
            'lastName' => 'required|min:5|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255',
        ]);

        if ($validate->fails()) {

            return response()->json([
                'status' => 400,
                'validate' => $validate->messages(),
            ]);
        } else {

            $otp = mt_rand(1, 10000);

            $password = bcrypt($request->password);

            $data['first_name'] = $request->firstName;
            $data['last_name'] = $request->lastName;
            $data['email'] = $request->email;
            $data['password'] = $password;
            $data['otp'] = $otp;

            $user = User::create($data);

            $mailData = [
                'otp' => $otp
            ];

            Mail::to($request->email)->send(new OtpMail($mailData));

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'email_verified_at' => 0])) {
                return response()->json([
                    'status' => 200,
                    'user' => $user
                ]);
            }
        }
    }

    public function resendOtp()
    {
        $user = Auth::user();

        $otp = mt_rand(1, 10000);

        $data['otp'] = $otp;

        User::where('id', $user->id)
            ->update($data);

        $mailData = [
            'otp' => $otp
        ];

        Mail::to($user->email)->send(new OtpMail($mailData));

        return response()->json([
            'status' => 200,
            'msg' => 'OTP sent, Please verify your email.'
        ]);
    }

    public function checkOtp(Request $request)
    {
        $user = User::where('otp', $request->otp)
            ->get();

        if (sizeof($user)) {
            $data['email_verified_at'] = true;
            User::where('otp', $request->otp)
                ->update($data);

            return response()->json([
                'status' => 200,
                'msg' => 'Your Email is verified.Please login.'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Your OTP is not match.Please check your email!'
            ]);
        }
    }

    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => 200,
                'message' => 'Login Succesfully.',
                "redirect_location" => url("friend-list")
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Email Or Password Incorrect'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function sendPasswordLink(Request $request)
    {
        $validate = validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {

            return response()->json([
                'status' => 400,
                'validate' => $validate->messages(),
            ]);
        }

        $user = User::where('email', $request->email)
            ->get();

        if (sizeof($user)) {
            foreach ($user as $user) {
                $url = route('reset.password', ['id' => $user->id]);
                $mailData = [
                    'url' => $url
                ];

                Mail::to($request->email)->send(new ResetPassword($mailData));
            }
        }
    }

    public function updatePassword(Request $request)
    {
        $id['id'] = $request->id;

        return view('updatepassword')->with(array('id' => $id));
    }

    public function createNewPassword(Request $request)
    {
        $validate = validator::make($request->all(), [
            'password' => 'required|confirmed|min:5|max:255',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'validate' => $validate->messages(),
            ]);
        } else {
            $password = bcrypt($request->password);
            $data['password'] = $password;

            User::where('id', $request->userId)
                ->update($data);

            return response()->json([
                'status' => 200,
            ]);
        }
    }
}
