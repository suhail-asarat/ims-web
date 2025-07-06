<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class Otp extends Model
{
    protected $fillable = [
        'email',
        'otp_code',
        'user_type',
        'registration_data',
        'expires_at',
        'is_verified'
    ];

    protected $casts = [
        'registration_data' => 'array',
        'expires_at' => 'datetime',
        'is_verified' => 'boolean'
    ];

    /**
     * Generate and store OTP for user registration
     */
    public static function generateOtp($email, $userType, $registrationData)
    {
        // Delete any existing OTPs for this email
        self::where('email', $email)->delete();

        // Generate 6-digit OTP
        $otpCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Create OTP record
        $otp = self::create([
            'email' => $email,
            'otp_code' => $otpCode,
            'user_type' => $userType,
            'registration_data' => $registrationData,
            'expires_at' => Carbon::now()->addMinutes(15), // 15 minutes expiry
            'is_verified' => false
        ]);

        // Send OTP email
        self::sendOtpEmail($email, $otpCode, $userType);

        return $otp;
    }

    /**
     * Verify OTP code
     */
    public static function verifyOtp($email, $otpCode)
    {
        $otp = self::where('email', $email)
            ->where('otp_code', $otpCode)
            ->where('is_verified', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($otp) {
            $otp->update(['is_verified' => true]);
            return $otp;
        }

        return null;
    }

    /**
     * Send OTP email
     */
    private static function sendOtpEmail($email, $otpCode, $userType)
    {
        $subject = 'Email Verification - ' . ucfirst($userType) . ' Registration';

        Mail::send([], [], function ($message) use ($email, $otpCode, $userType, $subject) {
            $message->to($email)
                ->subject($subject)
                ->html("
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                        <h2 style='color: #2563eb;'>Email Verification Required</h2>
                        <p>Hello,</p>
                        <p>Thank you for registering as a <strong>" . ucfirst($userType) . "</strong> on our platform.</p>
                        <p>To complete your registration, please use the following verification code:</p>
                        <div style='background-color: #f3f4f6; padding: 20px; text-align: center; margin: 20px 0; border-radius: 8px;'>
                            <h1 style='color: #1f2937; font-size: 32px; margin: 0; letter-spacing: 5px;'>{$otpCode}</h1>
                        </div>
                        <p><strong>Important:</strong> This code will expire in 15 minutes.</p>
                        <p>If you didn't request this verification, please ignore this email.</p>
                        <hr style='margin: 30px 0;'>
                        <p style='color: #6b7280; font-size: 14px;'>
                            This is an automated email. Please do not reply to this message.
                        </p>
                    </div>
                ");
        });
    }

    /**
     * Check if OTP is expired
     */
    public function isExpired()
    {
        return $this->expires_at < Carbon::now();
    }

    /**
     * Clean up expired OTPs (can be called via scheduled task)
     */
    public static function cleanupExpired()
    {
        return self::where('expires_at', '<', Carbon::now())->delete();
    }
}
