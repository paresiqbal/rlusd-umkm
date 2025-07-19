<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        /* General styling for email */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 150px;
        }

        .content {
            text-align: center;
            color: #333333;
        }

        .token {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #fa9302;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Top Center Logo -->
        <div class="logo">
            <img src="{{ asset('/assets/images/abdsi-logo.png') }}" alt="ABDSI SSDP KUMKM Logo">
        </div>

        <!-- Main Content with Border and Shadow -->
        <div class="content">
            <h2>Verifikasi Email</h2>
            <p>Gunakan kode 6 digit berikut untuk memverifikasi alamat email Anda: </p>

            <!-- Token Display -->
            <div class="token">
                {{ $token }}
            </div>
            <p>Kode ini akan kadaluarsa dalam 30 menit. Jika Anda tidak meminta hal ini, harap abaikan email ini.</p>
        </div>

        <!-- Footer Information -->
        <div class="footer">
            © {{ date('Y') }} ABDSI SSDP KUMKM. All rights reserved.
        </div>
    </div>
</body>

</html>
