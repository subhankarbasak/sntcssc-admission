<!DOCTYPE html>
<html>
<head>
    <title>Account Creation Successful - SNTCSSC Composite Course 2026 batch</title>
</head>
<body>
    <h1>Welcome, {{ $student->first_name }}!</h1>
    
    <p>Your account has been successfully created for the SNTCSSC Composite Course 2026 batch.</p>
    
    <h3>Your Login Credentials:</h3>
    <ul>
        <li><strong>Email:</strong> {{ $student->email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>

    <p><strong>Important Note:</strong></p>
    <p>This email is only to confirm your account creation. To appear for the admission test for SNTCSSC Composite Course 2026 batch, you need to apply through the dashboard.</p>
    
    <p>Please follow these steps:</p>
    <ol>
        <li>Login to your account</li>
        <li>Go to the Dashboard</li>
        <li>Find the "Available Notifications" section</li>
        <li>Apply for the admission test</li>
    </ol>

    <p><a href="{{ route('login') }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none;">Login Now</a></p>

    <p>Thank you,<br>Team SNTCSSC</p>
</body>
</html>