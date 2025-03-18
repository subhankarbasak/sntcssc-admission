<!-- resources/views/emails/student/password-reset.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <h1>Reset Your Password</h1>
    <p>Hello {{ $student->first_name }},</p>
    
    <p>You have requested to reset your password. Click the link below to proceed:</p>
    
    <p>
        <a href="{{ url('/student/reset-password/' . $token) }}">
            Reset Password
        </a>
    </p>
    
    <p>This link will expire in 60 minutes.</p>
    
    <p>If you didn't request a password reset, please ignore this email.</p>
    
    <p>Regards,<br>Team SNTCSSC</p>
</body>
</html>