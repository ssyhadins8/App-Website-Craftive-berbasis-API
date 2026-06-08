<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Lupa Sandi - Craftive</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F5E6D0;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #FCFAF7;
            border-radius: 24px;
            border: 1px solid #EFE3D3;
            box-shadow: 0 10px 30px rgba(61, 28, 8, 0.08);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #8B3A0F, #3D1C08);
            padding: 40px 20px;
            text-align: center;
            color: #FFFFFF;
        }
        .header h1 {
            margin: 0;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 14px;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 40px;
            color: #2E1A11;
            line-height: 1.6;
        }
        .content h2 {
            font-size: 20px;
            color: #3D1C08;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .otp-container {
            background-color: #EFE3D3;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            margin: 30px 0;
            border: 1px dashed #C1440E;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #8B3A0F;
            margin: 0;
        }
        .warning {
            font-size: 12px;
            color: #A0522D;
            background-color: rgba(169, 82, 45, 0.05);
            padding: 12px 16px;
            border-left: 4px solid #C1440E;
            border-radius: 4px;
            margin-top: 20px;
        }
        .footer {
            padding: 30px;
            text-align: center;
            background-color: #EFE3D3;
            font-size: 11px;
            color: #8B3A0F;
            border-top: 1px solid rgba(139, 58, 15, 0.1);
        }
        .footer a {
            color: #C1440E;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Craftive.</h1>
            <p>Warisan Kriya Autentik Nusantara</p>
        </div>
        <div class="content">
            <h2>Halo, {{ $userName }}!</h2>
            <p>Kami menerima permintaan untuk mereset kata sandi akun Craftive Anda. Silakan gunakan kode OTP 6-digit di bawah ini untuk memverifikasi identitas Anda dan mengganti kata sandi:</p>
            
            <div class="otp-container">
                <div class="otp-code">{{ $otp }}</div>
            </div>

            <p>Kode verifikasi ini hanya berlaku selama <strong>10 menit</strong> sejak email ini dikirimkan demi keamanan akun Anda.</p>

            <div class="warning">
                <strong>Penting:</strong> Jangan bagikan kode OTP ini kepada siapa pun, termasuk pihak yang mengaku dari Craftive. Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini dengan aman.
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} <strong>Craftive Indonesia</strong>. Hak Cipta Dilindungi.<br>
            Jl. Kriya Nusantara No. 47, Yogyakarta, Indonesia<br>
            <a href="http://localhost/craftive/public">Kunjungi Website Kami</a>
        </div>
    </div>
</body>
</html>
