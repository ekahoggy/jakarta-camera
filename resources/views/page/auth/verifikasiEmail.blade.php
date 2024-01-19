<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Akun Jakarta Camera</title>
    <style>
        /* Add your email styling here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: left;
            margin-bottom: 20px;
        }
        .verification-code {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-top: 10px;
        }
        .note {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Halo, {{$name}}</h2>
        </div>
        <p>Tolong masukkan kode verifikasi di bawah ini untuk masuk ke akun WVI kamu.</p>
        <p class="verification-code">Kode verifikasi: {{$kode}}</p>
        <p>Kode ini hanya dapat digunakan 1x dan akan berakhir dalam {{$expired}}</p>
        <p class="note">Jika kamu mendapatkan email ini namun tidak melakukan Login pada akun WVI, Kamu bisa mengabaikan email ini.</p>
        <div class="footer">
            <p>Terima kasih,</p>
            <p>Tim WVI</p>
        </div>
    </div>
</body>
</html>