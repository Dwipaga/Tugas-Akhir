<!DOCTYPE html>
<html>
<head>
    <title>Evaluation PDF</title>
</head>
<body>
    <div style="text-align: center;">
        <img src="{{ $logo_path }}" alt="Company Logo" style="width: 100px; height: auto;">
        <h2>{{ $company_name }}</h2>
        <p>{{ $address }}</p>
        <p>{{ $phone }}</p>
        <p>{{ $email }}</p>
        <h3>{{ $title }}</h3>
    </div>
    <div style="margin-top: 20px;">
        <p><strong>Nama Karyawan:</strong> {{ $asesi_name }}</p>
        <p><strong>Divisi:</strong> {{ $group_name }}</p>
        <p><strong>Bulan Penilaian:</strong> {{ $month }}</p>
    </div>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #000; padding: 8px;">Kriteria</th>
                <th style="border: 1px solid #000; padding: 8px;">Bobot</th>
                <th style="border: 1px solid #000; padding: 8px;">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $detail)
            <tr>
                <td style="border: 1px solid #000; padding: 8px;">{{ $detail['penilaian'] }}</td>
                <td style="border: 1px solid #000; padding: 8px;">{{ $detail['bobot'] }}</td>
                <td style="border: 1px solid #000; padding: 8px;">{{ $detail['score'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top: 20px;"><strong>Total Nilai:</strong> {{ $total_score }}</p>
</body>
</html>