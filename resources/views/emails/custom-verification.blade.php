<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Email</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h2 style="color: #0d6efd; margin-bottom: 20px;">Hello, {{ $user->name }}!</h2>
        <p>Thank you for registering on <strong>LaraSaaS Forge</strong>.</p>
        <p>Please click the button below to verify your email address and activate your workspace account:</p>
        
        <p style="text-align: center; margin: 35px 0;">
            <a href="{{ $verificationUrl }}" style="background-color: #0d6efd; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
                Verify Email Address
            </a>
        </p>
        
        <p>If you did not create an account, no further action is required.</p>
        <hr style="border: none; border-top: 1px solid #eee; margin-top: 30px;">
        <p style="font-size: 11px; color: #777;">If you have trouble clicking the button, copy and paste this URL into your browser: <br> <a href="{{ $verificationUrl }}" style="color: #0d6efd;">{{ $verificationUrl }}</a></p>
    </div>
</body>
</html>