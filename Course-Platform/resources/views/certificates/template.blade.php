<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "DejaVu Sans", sans-serif;
            position: relative;
        }

        /* background image full page */
        .bg {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-align: center;
        }

        .recipient {
            font-size: 38px;
            font-weight: 700;
            margin-top: 330px; /* posisi nama */
            color: #14365d; /* warna navy sesuai desain */
        }

        .course-title {
            font-size: 24px;
            font-weight: 700;
            margin-top: 18px; /* posisi "Sebagai:" */
            color: #14365d;
        }

        .course-label {
            font-size: 26px;
            margin-top: 5px;
            font-weight: bold;
            color: #14365d;
        }

        .footer-info {
            position: absolute;
            bottom: 80px;
            width: 100%;
            font-size: 14px;
            text-align: center;
            color: #14365d;
        }

        .meta {
            font-size: 11px;
            margin-top: 5px;
            color: #777;
        }
    </style>
</head>

<body>

    {{-- Background Canva --}}
    <img src="{{ public_path('certificate/canva-template.png') }}" class="bg">

    <div class="content">

        {{-- Nama Peserta --}}
        <div class="recipient">
            {{ strtoupper($user->name) }}
        </div>

        {{-- Judul Course --}}
        <div class="course-title">Sebagai :</div>
        <div class="course-label">
            {{ strtoupper($course->title) }}
        </div>

        {{-- Footer --}}
        <div class="footer-info">
            Tanggal Terbit: {{ $date }}  
            <div class="meta">
                Kode Sertifikat: {{ $code }}
            </div>
        </div>
    </div>

</body>
</html>
