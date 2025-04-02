<!DOCTYPE html>
<html>
<head>
    <title>{{ $fieldDisplayName ?? ucfirst($changedField) }} Update</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        /* Reset styles */
        body { margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4; color: #333333; }
        table { border-spacing: 0; }
        td { padding: 0; }
        img { border: 0; line-height: 100%; outline: none; text-decoration: none; }
        a { color: #007bff; text-decoration: none; }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            .container { width: 100% !important; max-width: 100% !important; }
            .content { padding: 15px !important; }
            .header, .footer { padding: 15px !important; }
            .status-table td, .receipt-table td { display: block !important; width: 100% !important; }
            .cta-button { padding: 8px 16px !important; font-size: 14px !important; }
        }

        /* Animation for SVG */
        .checkmark__circle { stroke-dasharray: 166; stroke-dashoffset: 166; stroke-width: 2; stroke-miterlimit: 10; stroke: #28a745; fill: none; animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards; }
        .checkmark { width: 60px; height: 60px; border-radius: 50%; display: block; stroke-width: 2; stroke: #fff; stroke-miterlimit: 10; margin: 20px auto; box-shadow: inset 0px 0px 0px #28a745; animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both; }
        .checkmark__check { transform-origin: 50% 50%; stroke-dasharray: 48; stroke-dashoffset: 48; animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards; }
        @keyframes stroke { 100% { stroke-dashoffset: 0; } }
        @keyframes scale { 0%, 100% { transform: none; } 50% { transform: scale3d(1.1, 1.1, 1); } }
        @keyframes fill { 100% { box-shadow: inset 0px 0px 0px 30px #28a745; } }
    </style>
</head>
<body>
    <?php
        // Define a mapping for field names to human-readable versions
        $fieldNames = [
            'status' => 'Application Status',
            'payment_status' => 'Payment Status',
            // Add more field names as needed
        ];
        $fieldDisplayName = $fieldNames[$changedField] ?? ucfirst($changedField);
    ?>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table class="container" width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td class="header" style="background-color: #007bff; padding: 20px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                            <img src="https://csscwb.in/assets/front-end/images/others/sntcssc-logo.png" alt="SNTCSSC Logo" style="max-width: 150px; height: auto; margin-bottom: 10px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">
                                {{ $fieldDisplayName }} Update
                            </h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td class="content" style="padding: 30px;">
                            <p style="font-size: 16px; line-height: 24px; margin: 0 0 15px;">Dear {{ $studentName }},</p>
                            
                            <p style="font-size: 16px; line-height: 24px; margin: 0 0 20px;">
                                @if($changedField === 'status')
                                    We’re pleased to inform you that the status of your application (ID: <strong>{{ $applicationId }}</strong>) has been updated.
                                @else
                                    We’re pleased to inform you that the payment status for your application (ID: <strong>{{ $applicationId }}</strong>) has been updated.
                                @endif
                            </p>

                            <!-- Animated Success Tick -->
                            @if($status === 'approved' || $status === 'paid')
                            <div style="text-align: center; margin: 20px 0;">
                                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                </svg>
                            </div>
                            @endif

                            <!-- Status Update -->
                            <table class="status-table" width="100%" cellpadding="10" cellspacing="0" style="background-color: #f8f9fa; border-radius: 4px; margin: 20px 0;">
                                <tr>
                                    <td width="30%" style="font-weight: bold; font-size: 16px;">{{ $fieldDisplayName }}:</td>
                                    <td width="70%" style="font-size: 16px; color: #007bff;">{{ ucfirst($status) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; font-size: 16px;">Application ID:</td>
                                    <td style="font-size: 16px;">{{ $applicationId }}</td>
                                </tr>
                            </table>

                            <!-- Payment Receipt Details -->
                            @if($changedField === 'payment_status' && $status === 'paid')
                            <h2 style="font-size: 18px; margin: 20px 0 10px; color: #007bff;">Payment Receipt Details</h2>
                            <table class="receipt-table" width="100%" cellpadding="10" cellspacing="0" style="border: 1px solid #dee2e6; border-radius: 4px;">
                                <tr style="background-color: #f8f9fa;">
                                    <td width="40%" style="font-weight: bold; font-size: 14px;">Transaction No:</td>
                                    <td width="60%" style="font-size: 14px;">{{ $application->payment->transaction_id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; font-size: 14px;">Transaction Date:</td>
                                    <td style="font-size: 14px;">{{ $application->payment->transaction_date->format('d/m/Y') ?? 'N/A' }}</td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="font-weight: bold; font-size: 14px;">Amount:</td>
                                    <td style="font-size: 14px;">{{ $application->payment->currency ?? 'Rs.' }} {{ number_format($application->payment->amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; font-size: 14px;">Method:</td>
                                    <td style="font-size: 14px;">{{ $application->payment->method ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; font-size: 14px;">Status:</td>
                                    <td style="font-size: 14px; color: #28a745;">{{ ucfirst($status) }}</td>
                                </tr>
                            </table>
                            @endif

                            <p style="font-size: 16px; line-height: 24px; margin: 20px 0;">
                                For more details about your application or payment, please log in to your account:
                            </p>

                            <!-- Call-to-Action Button -->
                            <p style="text-align: center; margin: 20px 0;">
                                <a href="{{ url('/login') }}" class="cta-button" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 4px; font-size: 16px;">View Account</a>
                            </p>

                            <p style="font-size: 16px; line-height: 24px; margin: 20px 0 0;">
                                If you have any questions, feel free to contact our support team at <a href="mailto:iascoaching.sntcssc@gmail.com">iascoaching.sntcssc@gmail.com</a>.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="footer" style="padding: 20px; background-color: #f8f9fa; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; text-align: center;">
                            <p style="margin: 0; font-size: 14px; color: #666666;">
                                Thank You,<br>
                                <strong>Team SNTCSSC</strong>
                            </p>
                            <p style="margin: 10px 0; font-size: 12px; color: #999999;">
                                © {{ date('Y') }} SNTCSSC. All rights reserved.
                            </p>
                            <p style="margin: 10px 0; font-size: 12px; color: #999999;">
                                <a href="{{ url('/unsubscribe?email=' . urlencode($application->studentProfile?->email) . '&type=' . $changedField) }}" style="color: #999999; text-decoration: underline;">Unsubscribe</a>
                            </p>
                            <p style="margin: 10px 0 0; font-size: 12px; color: #999999;">
                                <em>Note*: This is a system generated mail, do not reply to this mail.</em>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>