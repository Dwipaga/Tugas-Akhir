<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Perjanjian Kerja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
            color: #333;
            text-align: justify;
            /* Untuk meratakan teks kiri-kanan */
        }

        p,
        ol,
        li {
            text-align: justify;
            /* Memastikan elemen paragraf dan list juga rata */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header img {
            max-width: 150px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .contract-number {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
            text-decoration: underline;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
        }

        .signature div {
            width: 45%;
            text-align: center;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            margin: 40px 0 10px 0;
            /* Jarak antara teks dan garis tanda tangan */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ $logo_path }}" alt="Cubiconia Logo">
            <div class="title">SURAT PERJANJIAN KERJA</div>
            <div class="contract-number">Nomor: 021/HRM/07/{{ date('Y') }}</div>
        </div>

        <div class="section">
            <p>Pada hari ini, {{ date('l') }}, tanggal {{ $tanggal_kontrak }}, bertempat di Jakarta, yang bertanda tangan di bawah ini:</p>
            <p>
                <strong>Nama:</strong> Muhammad Lingga Praja<br>
                <strong>Jabatan:</strong> Direktur Operasional {{ $company_name }}<br>
                <strong>Alamat:</strong> {{ $company_address }}
            </p>
            <p>Bertindak untuk dan atas nama {{ $company_name }}, selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.</p>
            <p>
                <strong>Nama:</strong> {{ $nama_karyawan }}<br>
                <strong>Alamat:</strong> {{ $alamat }}<br>
                Selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong>.
            </p>
        </div>

        <!-- Rest of the template remains the same as provided previously -->
        <!-- Include all sections (Preambule, Pasal 1-10, Signature) from the original template -->
        <div class="section">
            <div class="section-title">Preambule</div>
            <p>PARA PIHAK menerangkan terlebih dahulu:</p>
            <ol>
                <li>Bahwa PIHAK PERTAMA adalah direksi dari perusahaan.</li>
                <li>Bahwa PIHAK KEDUA ingin mendapatkan pengetahuan, keterampilan, pengalaman, serta sikap kerja dan karenanya akan mengikuti aturan Kerja yang diselenggarakan PIHAK PERTAMA.</li>
            </ol>
            <p>Sesuai dengan hal-hal tersebut di atas, maka PIHAK KEDUA dengan ini menyatakan kesediaannya untuk mendaftarkan diri mengikuti aturan Kerja yang diselenggarakan oleh PIHAK PERTAMA, dengan syarat-syarat dari ketentuan-ketentuan yang diatur sebagai berikut:</p>
        </div>

        <div class="section">
            <div class="section-title">Pasal 1: Jangka Waktu dan Tempat Kerja</div>
            <ol type="a">
                <li>PIHAK PERTAMA menerima PIHAK KEDUA sebagai peserta Program Kerja dengan penempatan di tim {{ $tim_penempatan }} selama {{ $durasi }} terhitung mulai tanggal {{ $tanggal_mulai }} sampai dengan tanggal {{ $tanggal_berakhir }}.</li>
                <li>Jangka waktu tersebut dapat diperpanjang atau diperpendek atas dasar pertimbangan dan/atau rekomendasi tertulis dari PIHAK PERTAMA dan/atau pimpinan langsung yang mewakili.</li>
                <li>Dalam hal demikian, PIHAK KEDUA tidak berhak menolak ataupun menuntut ganti rugi berupa apapun kepada PIHAK PERTAMA.</li>
                <li>Lokasi bekerja berlaku fleksible sesuai dengan kebutuhan dan penempatan yang ditentukan oleh PIHAK PERTAMA dan/atau pimpinan langsung yang mewakili.</li>
                <li>Jam kerja berlaku fleksibel sesuai dengan kondisi dan kebutuhan yang ditentukan oleh PIHAK PERTAMA dan/atau pimpinan langsung yang mewakili dengan acuan kehadiran minimal 40 jam per minggu baik online maupun offline.</li>
                <li>Sekurang-kurangnya satu kali dalam sebulan PIHAK KEDUA wajib mengikuti pertemuan koordinasi offline yang difasilitasi dengan waktu dan tempat sesuai kesepakatan PIHAK KEDUA dengan anggota tim yang lain sesuai dengan penempatan yang ditentukan PIHAK PERTAMA dan/atau pimpinan langsung yang mewakili.</li>
            </ol>
        </div>

        <div class="section">
            <div class="section-title">Pasal 2: Kesanggupan Pihak Kedua</div>
            <ol type="a">
                <li>PIHAK KEDUA wajib melaksanakan tugas dan pekerjaan sesuai dengan KPI (Key Performance Indicator) yang telah ditentukan oleh PIHAK PERTAMA dan/atau pimpinan langsung yang mewakili dengan acuan kehadiran minimal 40 jam per minggu baik online maupun offline.</li>
                <li>PIHAK KEDUA wajib mengikuti pertemuan koordinasi rutin dan/atau pertemuan dengan pelanggan yang diadakan oleh PIHAK PERTAMA dan/atau pimpinan langsung yang mewakili sesuai kebutuhan pekerjaan.</li>
                <li>PIHAK KEDUA wajib menempatkan seluruh hasil kerja dalam sistem SVN (Subversioning System) dan Cloud infrastructure yang penempatan dan akses dimiliki oleh PIHAK PERTAMA.</li>
                <li>Sesuai dengan pasal 1 huruf (e), selama jam kerja (08:00-17:00) PIHAK KEDUA harus dapat dihubungi melalui Call atau WhatsApp (WA) dengan maksimal waktu respon terhadap WA atau Call adalah 1 jam.</li>
            </ol>
        </div>

        <div class="section">
            <div class="section-title">Pasal 3: Kesanggupan Pihak Pertama</div>
            <p>PIHAK PERTAMA akan memberikan penggajian yang dibayarkan di minggu pertama setiap bulannya dengan ditransfer kepada PIHAK KEDUA di rekening sebagai berikut:</p>
            <p>
                <strong>Bank:</strong> {{ $nama_bank }}<br>
                <strong>Nomor Rekening:</strong> {{ $nomor_rekening }}<br>
                <strong>Nama Akun:</strong> {{ $nama_acc }}
            </p>
        </div>

        <div class="section">
            <div class="section-title">Pasal 4: Kerahasiaan dan Integritas</div>
            <ol type="a">
                <li>PIHAK KEDUA dengan ini setuju dan menyatakan bahwa atas semua data, informasi, dokumen dan/atau data dalam bentuk apapun yang diterima dari PIHAK PERTAMA baik secara langsung atau tidak langsung sehubungan dengan pelaksanaan dari PERJANJIAN KERJA adalah merupakan data dan/atau dokumen rahasia (selanjutnya disebut Informasi Rahasia).</li>
                <li>PIHAK KEDUA dengan ini setuju dan berjanji bahwa selama dan setelah berakhirnya pelaksanaan PERJANJIAN KERJA tidak akan menyimpan, menyebarluaskan atau melakukan publikasi dengan cara apapun juga atas setiap Informasi Rahasia kepada pihak manapun tanpa persetujuan tertulis dari PIHAK PERTAMA kecuali memberikan Informasi Rahasia kepada pihak terafiliasi yang diminta untuk melaksanakan pekerjaan.</li>
                <li>Bahwa semua bentuk dokumen, laporan dan/atau data pekerjaan dalam bentuk cetakan (hardcopy), softcopy ataupun software dan bentuk lain yang dibuat oleh PIHAK KEDUA adalah hak milik PIHAK PERTAMA dan PIHAK PERTAMA berhak untuk meminta PIHAK KEDUA untuk menyerahkan dokumen-dokumen yang terkait dengan Informasi Rahasia tersebut dalam bentuk dan waktu yang ditetapkan oleh PIHAK PERTAMA.</li>
                <li>PIHAK KEDUA dengan ini setuju untuk melaksanakan seluruh tugas, fungsi, tanggung jawab, wewenang dan peran sesuai dengan jabatannya dan tidak akan melakukan korupsi, kolusi dan nepotisme.</li>
            </ol>
        </div>

        <div class="section">
            <div class="section-title">Pasal 5: Evaluasi dan Sanksi</div>
            <ol type="a">
                <li>PIHAK PERTAMA mengadakan evaluasi atas prestasi, penampilan serta perilaku dan sikap kerja PIHAK KEDUA selama pelaksanaan kerja.</li>
                <li>Jika PIHAK KEDUA dinyatakan tidak dapat melanjutkan kerja yang dimaksud, PIHAK PERTAMA berhak mengakhiri pelaksanaan kerja PIHAK KEDUA tanpa kewajiban memberikan kompensasi dalam bentuk apapun.</li>
            </ol>
        </div>

        <div class="section">
            <div class="section-title">Pasal 6: Akhir Masa kerja</div>
            <p>PIHAK PERTAMA dapat mengakhiri masa kerja PIHAK KEDUA setiap saat, tanpa kompensasi dalam bentuk apapun, apabila PIHAK KEDUA melakukan pelanggaran berat.</p>
        </div>

        <div class="section">
            <div class="section-title">Pasal 7: Pengunduran Diri</div>
            <ol type="a">
                <li>Jika PIHAK KEDUA mengundurkan diri selama masih dalam masa kerja dengan alasan yang tidak dapat diterima oleh PIHAK PERTAMA, maka PIHAK KEDUA tidak akan mendapatkan ganti rugi dalam bentuk apapun.</li>
                <li>Apabila PIHAK KEDUA mengajukan pengunduran diri sebelum Perjanjian berakhir, maka PIHAK KEDUA berkewajiban untuk membayar ganti rugi kepada PIHAK PERTAMA sebesar jumlah gaji PIHAK KEDUA sampai waktu berakhirnya jangka waktu Perjanjian Kerja kerja.</li>
            </ol>
        </div>

        <div class="section">
            <div class="section-title">Pasal 8: Perselisihan</div>
            <ol type="a">
                <li>Apabila terjadi perselisihan selama masa kerja di Perusahaan, para pihak sepakat akan menyelesaikan secara musyawarah untuk mufakat, jika dengan cara musyawarah tidak tercapai penyelesaian, kedua belah pihak akan menyelesaikannya sesuai dengan ketentuan hukum yang berlaku di Republik Indonesia.</li>
                <li>Apabila perselisihan itu tetap tidak dapat diselesaikan, maka kedua belah pihak memilih Pengadilan Negeri untuk menyelesaikannya.</li>
            </ol>
        </div>

        <div class="section">
            <div class="section-title">Pasal 9: Lain-lain</div>
            <p>Untuk hal-hal yang belum diatur dalam perjanjian ini, berlaku ketentuan dari peraturan Perusahaan di mana PIHAK KEDUA ditempatkan, sepanjang tidak bertentangan dengan peraturan ketenagakerjaan yang berlaku di Republik Indonesia.</p>
        </div>

        <div class="section">
            <div class="section-title">Pasal 10: Penutup</div>
            <p>Perjanjian ini dibuat dan ditandatangani oleh kedua belah pihak dalam keadaan sadar dan tanpa paksaan dari pihak manapun dan mulai berlaku sesuai jangka waktu masa kerja.</p>
        </div>

        <div class="signature row">
           
            <div class="col col-6" style="text-align: right;">
                <p>PIHAK KEDUA</p>
                <br>
                <br>
                <p>{{ $nama_karyawan }}</p>
            </div>
        </div>


        <div style="text-align: right; margin-top: 20px;">
            <p>Ditetapkan di: Jakarta</p>
            <p>Pada tanggal: {{ $tanggal_kontrak }}</p>
        </div>
    </div>
</body>

</html>