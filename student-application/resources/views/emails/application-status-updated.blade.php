<!DOCTYPE html>
<html>
<head>
    <title>Application Status Update</title>
</head>
<body>
    <h1>Hello {{ $studentName }},</h1>
    
    <p>We wanted to inform you that your application (ID: {{ $applicationId }}) has been updated:</p>
    
    <p>
        <strong>{{ ucfirst($changedField) }}:</strong> 
        {{ ucfirst($status) }}
    </p>
    
    <p>Please log in to your account for more details or contact support if you have any questions.</p>
    
    <p>Best regards,<br>
    Application Team</p>
</body>
</html>