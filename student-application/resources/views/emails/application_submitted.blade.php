<!DOCTYPE html>
<html>
<head>
    <title>Application Submitted Successfully</title>
</head>
<body>
    <h1>Application Submission Confirmation</h1>
    
    <p>Dear {{ $studentName }},</p>
    
    <p>Congratulations! Your application for the SNTCSSC Composite Course 2026 Batch Admission Test has been successfully submitted.</p>
    
    <p>Your Application Number: <strong>{{ $applicationNumber }}</strong></p>
    
    <p>You can download your submitted application using the following link:</p>
    <p><a href="{{ $downloadUrl }}" target="_blank">Download Application</a></p>
    
    <p>Please keep this application number safe for future reference. You will receive further communication regarding the admission test schedule and payment verification soon.</p>
    
    <p>Best regards,<br>
    Satyendra Nath Tagore Civil Services Study Centre<br>
    Government of West Bengal</p>
</body>
</html>