<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat – {{ $course->title }}</title>
    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            text-align:center;
            padding:40px;
        }
        .border-box{
            border:6px double #1d4ed8;
            padding:40px;
        }
        h1{font-size:32px;margin-bottom:10px}
        h2{font-size:20px;margin:10px 0}
        p{font-size:14px;margin:6px 0}
        .name{font-size:24px;font-weight:bold;margin:16px 0}
        .code{font-size:10px;color:#6b7280;margin-top:20px}
    </style>
</head>
<body>
<div class="border-box">
    <h1>SERTIFIKAT</h1>
    <p>Dengan ini menyatakan bahwa</p>
    <p class="name">{{ $user->name }}</p>
    <p>telah menyelesaikan course</p>
    <h2>“{{ $course->title }}”</h2>
    <p>pada tanggal {{ $certificate->issued_at->format('d F Y') }}.</p>

    <p style="margin-top:30px;">Universitas Hasanuddin – EDVO</p>
    <div class="code">
        Kode Sertifikat: {{ $certificate->certificate_code }}
    </div>
</div>
</body>
</html>
