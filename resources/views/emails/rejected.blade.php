<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemberitahuan Status Lamaran</title>
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
            border-top: 5px solid #dc3545;
        }
        .email-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .email-header img {
            max-width: 180px;
        }
        .email-body h2 {
            color: #dc3545;
        }
        .email-footer {
            margin-top: 40px;
            text-align: left;
            font-size: 14px;
            color: #666;
        }
        .message-box {
            background-color: #fff5f5;
            padding: 20px;
            border-left: 5px solid #dc3545;
            margin: 20px 0;
            border-radius: 4px;
        }
        .encouragement-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 5px solid #6c757d;
            margin: 20px 0;
            border-radius: 4px;
        }
        .thank-you {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <!-- Logo perusahaan bisa ditambahkan di sini -->
        </div>

        <div class="email-body">
            <h2>Dear {{ $firstname }} {{ $lastname }},</h2>

            <p>
                Terima kasih telah melamar di <strong>PT. Cubiconia Kanaya Pratama</strong> untuk posisi:
                <strong>{{ $jobTitle }}</strong>.
            </p>

            <div class="message-box">
                <p>
                    Setelah melalui proses seleksi yang ketat, kami dengan berat hati harus menginformasikan bahwa 
                    lamaran Anda untuk posisi tersebut <strong>tidak dapat kami terima</strong> pada saat ini.
                </p>
            </div>

            <p>
                Keputusan ini bukanlah cerminan dari kualitas atau kemampuan Anda, melainkan karena adanya 
                kandidat lain yang lebih sesuai dengan kebutuhan spesifik posisi ini.
            </p>

            <div class="encouragement-box">
                <p><strong>Jangan menyerah!</strong></p>
                <p>
                    Kami sangat menghargai minat Anda untuk bergabung dengan PT. Cubiconia Kanaya Pratama. 
                    Profil Anda akan tetap kami simpan dalam database kami untuk peluang kerja di masa mendatang 
                    yang mungkin lebih sesuai dengan kualifikasi Anda.
                </p>
            </div>

            <p>
                Kami juga mengundang Anda untuk terus mengikuti perkembangan lowongan kerja di perusahaan kami 
                melalui website resmi dan media sosial kami.
            </p>

            <p class="thank-you">
                Sekali lagi, terima kasih atas waktu dan minat Anda. Semoga sukses dalam pencarian kerja Anda!
            </p>
        </div>

        <div class="email-footer">
            <p>Best Regards,</p>
            <p><strong>HRD PT. Cubiconia Kanaya Pratama</strong></p>
            <hr style="border: 1px solid #eee; margin: 20px 0;">
            <p style="font-size: 12px; color: #999;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>