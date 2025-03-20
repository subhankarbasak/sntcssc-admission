<!-- resources/views/maintenance.blade.php -->
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\Setting::getCachedSettings()->app_name }} - Maintenance</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .maintenance-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 600px;
            text-align: center;
            margin: 20px;
        }

        .logo {
            max-width: 180px;
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .maintenance-title {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .maintenance-text {
            color: #7f8c8d;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* SVG Animation Styles */
        .gear {
            animation: spin 4s linear infinite;
            transform-origin: center;
        }

        .gear-small {
            animation: spin 3s linear infinite reverse;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .svg-container {
            margin: 2rem 0;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            background: #e74c3c;
            border-radius: 50%;
            display: inline-block;
            margin-left: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .footer-text {
            color: #95a5a6;
            font-size: 0.9rem;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        @if(\App\Models\Setting::getCachedSettings()->logo)
            <img src="{{ Storage::url(\App\Models\Setting::getCachedSettings()->logo) }}" 
                 alt="Logo" class="logo img-fluid">
        @else
            <h3 class="maintenance-title">{{ \App\Models\Setting::getCachedSettings()->app_name }}</h3>
        @endif

        <h1 class="maintenance-title">
            Under Maintenance
            <span class="status-dot"></span>
        </h1>

        <p class="maintenance-text">
            We're currently upgrading our systems to provide you with a better experience. 
            Please check back soon!
        </p>

        <div class="svg-container">
            <svg width="200" height="200" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Large Gear -->
                <g class="gear">
                    <path fill="#3498db" d="M100 20c-44.183 0-80 35.817-80 80s35.817 80 80 80 80-35.817 80-80-35.817-80-80-80zm0 144c-35.346 0-64-28.654-64-64s28.654-64 64-64 64 28.654 64 64-28.654 64-64 64z"/>
                    <path fill="#2980b9" d="M120 100l20 10-10 20-20-10-20 10-10-20 20-10 10-20z"/>
                    <circle fill="#ecf0f1" cx="100" cy="100" r="20"/>
                </g>
                <!-- Small Gear -->
                <g class="gear-small" transform="translate(120 120)">
                    <path fill="#e74c3c" d="M30 0c-16.569 0-30 13.431-30 30s13.431 30 30 30 30-13.431 30-30-13.431-30-30-30zm0 48c-9.941 0-18-8.059-18-18s8.059-18 18-18 18 8.059 18 18-8.059 18-18 18z"/>
                    <path fill="#c0392b" d="M40 30l10 5-5 10-10-5-10 5-5-10 10-5 5-10z"/>
                </g>
                <!-- Wrench -->
                <path fill="#7f8c8d" transform="rotate(45 100 100)" 
                      d="M80 140l40-40-20-20-40 40c-5.523 5.523-5.523 14.477 0 20s14.477 5.523 20 0zm20-60l20 20 20-20-20-20z"/>
            </svg>
        </div>

        <p class="footer-text">
            <i class="fas fa-tools me-2"></i>
            {{ \App\Models\Setting::getCachedSettings()->copyright_text }}
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.maintenance-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>