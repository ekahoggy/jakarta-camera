<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih atas Donasi Anda</title>
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
            text-align: center;
            margin-bottom: 20px;
        }
        .thank-you {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin-top: 10px;
        }
        .message {
            margin-top: 20px;
            font-size: 16px;
            color: #333;
        }
        .info {
            margin-top: 10px;
            font-size: 12px;
            color: #888;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Terimakasih {{$nama}} atas partisipasi Anda memberikan donasi melalui Wanaha Visi Indonesia.</h2>
        </div>
        <p class="message">Kami masih menunggu Anda menyelesaikan proses donasi. dengan nominal Donasi</p>
        <p class="thank-you">Rp. {{number_format($nominal)}}</p>
        <p class="message">Donasi Anda akan sangat berarti bagi kami dalam melaksanakan misi kami.</p>
        <hr>
        <p class="info">Apabila membutuhkan bantuan lebih lanjut, silakan menghubungi kami melalui email <a href="mailto:sponsoranak@wvi.or.id" target="_blank">sponsoranak@wvi.or.id</a> atau WA <a href="https://wa.me/62811156041" target="_blank">+62811156041</a></p>
        <div class="footer">
            <p>Salam hangat,</p>
            <p>Tim Wanaha Visi Indonesia</p>
        </div>
    </div>
</body>
</html>