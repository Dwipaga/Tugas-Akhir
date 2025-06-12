<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Anda Diterima</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            border-top: 5px solid #0467be;
        }
        .email-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .email-header img {
            max-width: 180px;
        }
        .email-body h2 {
            color: #0467be;
        }
        .email-footer {
            margin-top: 40px;
            text-align: left;
            font-size: 14px;
            color: #666;
        }
        .credentials {
            background-color: #f0f8ff;
            padding: 15px;
            border-left: 5px solid #0467be;
            margin: 20px 0;
        }
        .credentials p {
            margin: 5px 0;
            font-family: monospace;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        

        <div class="email-body">
            <h2>Dear {{ $firstname }} {{ $lastname }},</h2>

            <p>
                Selamat! Anda telah diterima di <strong>PT. Cubiconia Kanaya Pratama</strong> untuk posisi:
                <strong>{{ $jobTitle }}</strong>.
            </p>

            <p>Silakan gunakan kredensial berikut untuk login ke sistem kami:</p>

            <div class="credentials">
                <p><strong>Link    :</strong> @php
                getenv('APP_URL');
                @endphp</p>
                <p><strong>Username:</strong> {{ $email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>

            <p>Pastikan untuk menjaga kerahasiaan informasi ini dan segera ubah password Anda setelah login pertama.</p>
        </div>

        <div class="email-footer">
            <p>Best Regards,</p>
            <p><strong>HRD PT. Cubiconia Kanaya Pratama</strong></p>
        </div>
    </div>
</body>
</html>
