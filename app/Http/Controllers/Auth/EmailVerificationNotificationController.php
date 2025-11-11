<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendEmailOtpMail;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        // if ($request->user()->hasVerifiedEmail()) {
        //     return redirect()->intended(route('dashboard', absolute: false));
        // }
        // $request->user()->sendEmailVerificationNotification();

        // return back()->with('status', 'verification-link-sent');

        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        // generate 6 digit OTP
        $otp = rand(100000, 999999);

        // store otp + expiry
        $user->email_otp = $otp;
        $user->email_otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // send OTP mail
        Mail::to($user->email)->send(new SendEmailOtpMail($user->email_otp));

        // return back()->with('status', 'Verification code sent to your email');
        return redirect()->route('verification.otp');
    }
}
