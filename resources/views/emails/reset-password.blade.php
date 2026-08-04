<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f9; color: #333333; margin: 0; padding: 0; -webkit-font-smoothing: antialiased;">
    <div style="background-color: #f4f6f9; padding: 40px 10px;">
        <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 0; border-radius: 12px; overflow: hidden; border: 1px solid #eef2f7; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);">
            
            <!-- মেইলের হেডার অংশ (রয়্যাল ডার্ক থিম) -->
            <div style="background-color: #1a237e; padding: 30px; text-align: center;">
                <h3 style="color: #ffffff; margin: 0; font-weight: 700; font-size: 1.6rem; letter-spacing: -0.5px;">
                    <span style="color: #ffc107;">★</span> LaraSaaS Forge
                </h3>
            </div>

            <!-- মেইলের মূল মেসেজ বডি -->
            <div style="padding: 40px 30px;">
                <h3 style="color: #1e1e2d; margin-top: 0; font-weight: 700; font-size: 1.25rem;">Password Reset Request</h3>
                <p style="color: #4a5568; line-height: 1.6; font-size: 15px;">Hello, <strong>{{ $name }}</strong>,</p>
                <p style="color: #455a64; line-height: 1.6; font-size: 15px;">You are receiving this email because we received a password reset request for your account on LaraSaaS Forge.</p>
                
                <!-- চমৎকার ও হাইলাইটেড অ্যাকশন বোতাম -->
                <p style="text-align: center; margin: 35px 0;">
                    <a href="{{ $resetUrl }}" style="background-color: #0d6efd; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block; font-size: 15px; box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);">
                        Reset Password
                    </a>
                </p>
                
                <p style="color: #4a5568; font-size: 14px; line-height: 1.6;">This password reset link will expire in <strong>60 minutes</strong>.</p>
                <p style="color: #777777; font-size: 14px; margin-bottom: 0; line-height: 1.6;">If you did not request a password reset, no further action is required.</p>
                
                <hr style="border: none; border-top: 1px solid #eef2f7; margin-top: 30px; margin-bottom: 20px;">
                
                <!-- লিংক ক্লিকে সমস্যা হলে কুইক কপি-পেস্ট করার লিংক -->
                <p style="font-size: 11px; color: #777777; line-height: 1.6; word-break: break-all;">
                    If you have trouble clicking the button, copy and paste this URL into your browser: <br> 
                    <a href="{{ $resetUrl }}" style="color: #0d6efd; text-decoration: none;">{{ $resetUrl }}</a>
                </p>
            </div>

            <!-- মেইলের ফুটার সেকশন -->
            <div style="background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #eef2f7; font-size: 11px; color: #777777;">
                <p style="margin: 0;">&copy; {{ date('Y') }} LaraSaaS Forge. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>