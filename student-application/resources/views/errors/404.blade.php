<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        h1 { font-size: 50px; }
        p { font-size: 20px; }
        .error-details { background: #f8d7da; color: #721c24; padding: 20px; margin-top: 20px; text-align: left; }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Oops! The page you are looking for could not be found.</p>
    <a href="{{ url('/') }}">Return to Home</a>

    @if (!empty($errorDetails) && app()->environment('local'))
        <div class="error-details">
            <h2>Error Details (Local Environment Only)</h2>
            <p><strong>Message:</strong> {{ $errorDetails['message'] }}</p>
            <p><strong>Code:</strong> {{ $errorDetails['code'] }}</p>
            <p><strong>File:</strong> {{ $errorDetails['file'] }}</p>
            <p><strong>Line:</strong> {{ $errorDetails['line'] }}</p>
            <pre><strong>Stack Trace:</strong><br>{{ $errorDetails['trace'] }}</pre>
        </div>
    @endif
</body>
</html>