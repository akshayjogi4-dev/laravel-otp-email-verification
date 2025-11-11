<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifyOtpController extends Controller
{
    public function verify_otp(Request $request){
        $request->validate([
            'email_otp' => 'required|digits:6'
        ]);

        $user = auth()->user();

        // Check if OTP match & not expired
        if ($user->email_otp === $request->email_otp && $user->email_otp_expires_at &&
        now()->lessThanOrEqualTo($user->email_otp_expires_at)) {
            // Mark email verified
            $user->email_verified_at = now();
            $user->email_otp = null; // clear otp
            $user->email_otp_expires_at = null;
            $user->save();

            return redirect()
                ->route('dashboard')
                ->with('verified', true);
        }

        return back()->withErrors([
            'email_otp' => 'Invalid or expired OTP. Please try again.'
        ]);
    }
}
