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
        }

        .page {
            width: 297mm;
            height: 210mm;
            padding: 20mm;
            box-sizing: border-box;
            position: relative;
        }

        .border-outer {
            border: 6px solid #b8860b; 
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 6mm;
        }

        .border-inner {
            border: 2px solid #d4af37; 
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 12mm 18mm;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 10mm;
        }

        .logo {
            height: 40mm;
            margin-bottom: 4mm;
        }

        .institution {
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #333;
        }

        .subtitle {
            font-size: 11pt;
            color: #555;
        }

        .certificate-title {
            text-align: center;
            margin: 8mm 0 4mm 0;
        }

        .certificate-title h1 {
            font-size: 26pt;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #b8860b;
            margin: 0;
        }

        .certificate-title .line {
            width: 60mm;
            height: 2px;
            background-color: #d4af37;
            margin: 3mm auto 0 auto;
        }

        .content {
            text-align: center;
            margin-top: 6mm;
        }

        .label-small {
            font-size: 11pt;
            color: #555;
        }

        .student-name {
            font-size: 24pt;
            font-weight: bold;
            margin: 3mm 0 5mm 0;
            color: #222;
        }

        .course-title {
            font-size: 15pt;
            font-weight: bold;
            margin: 3mm 0;
            color: #333;
        }

        .description {
            font-size: 11pt;
            color: #444;
            margin: 2mm 0 6mm 0;
        }

        .info-row {
            width: 100%;
            margin-top: 8mm;
            font-size: 10pt;
            color: #444;
        }

        .info-row td {
            padding: 2mm 0;
        }

        .info-label {
            text-align: left;
            width: 25%;
        }

        .info-separator {
            width: 3%;
            text-align: center;
        }

        .info-value {
            text-align: left;
            width: 72%;
        }

        .footer {
            position: absolute;
            bottom: 14mm;
            left: 18mm;
            right: 18mm;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            color: #333;
        }

        .footer-table td {
            text-align: center;
            vertical-align: bottom;
        }

        .sign-line {
            margin-top: 14mm;
            border-top: 1px solid #555;
            width: 70mm;
            margin-left: auto;
            margin-right: auto;
        }

        .sign-title {
            margin-top: 2mm;
            font-size: 10pt;
        }

        .meta {
            position: absolute;
            bottom: 4mm;
            right: 18mm;
            font-size: 8pt;
            color: #777;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 55pt;
            color: rgba(200, 200, 200, 0.2);
            text-transform: uppercase;
            letter-spacing: 8px;
            z-index: -1;
        }
    </style>
</head>
<body>
<div class="page">
    <div class="border-outer">
        <div class="border-inner">

            <div class="watermark">
                CERTIFICATE
            </div>
            <div class="header">
                @if(!empty($logoPath))
                    <img src="{{ $logoPath }}" class="logo" alt="Logo">
                @endif

                <div class="institution">
                    {{ $institutionName ?? 'UNIVERSITAS / INSTITUSI' }}
                </div>
                @if(!empty($institutionSubtitle))
                    <div class="subtitle">
                        {{ $institutionSubtitle }}
                    </div>
                @endif
            </div>

            <div class="certificate-title">
                <h1>SERTIFIKAT</h1>
                <div class="line"></div>
            </div>

            <div class="content">
                <div class="label-small">
                    Diberikan kepada:
                </div>
                <div class="student-name">
                    {{ $user->name }}
                </div>

                <div class="label-small">
                    Sebagai penghargaan atas keberhasilan menyelesaikan kursus:
                </div>
                <div class="course-title">
                    {{ $course->title }}
                </div>

                @if(!empty($courseDescription))
                    <div class="description">
                        {{ $courseDescription }}
                    </div>
                @else
                    <div class="description">
                        Telah menyelesaikan seluruh materi dan persyaratan pembelajaran yang ditetapkan
                        pada kursus ini dengan penuh dedikasi dan komitmen.
                    </div>
                @endif
            </div>

            <table class="info-row">
                <tr>
                    <td class="info-label">Nama Peserta</td>
                    <td class="info-separator">:</td>
                    <td class="info-value">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="info-label">Nama Kursus</td>
                    <td class="info-separator">:</td>
                    <td class="info-value">{{ $course->title }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tanggal Terbit</td>
                    <td class="info-separator">:</td>
                    <td class="info-value">{{ $date }}</td>
                </tr>
                <tr>
                    <td class="info-label">Kode Sertifikat</td>
                    <td class="info-separator">:</td>
                    <td class="info-value">{{ $code }}</td>
                </tr>
            </table>

            <div class="footer">
                <table class="footer-table">
                    <tr>
                        <td>
                            @if(!empty($leftSignTitle))
                                <div>{{ $leftSignLocation ?? '' }}, {{ $date }}</div>
                            @endif
                        </td>
                        <td>
                            @if(!empty($rightSignTitle))
                                <div>{{ $rightSignLocation ?? '' }}, {{ $date }}</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @if(!empty($leftSignTitle))
                                <div class="sign-line"></div>
                                <div class="sign-title">
                                    {{ $leftSignName ?? 'Nama Penandatangan Kiri' }}<br>
                                    <em>{{ $leftSignTitle }}</em>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if(!empty($rightSignTitle))
                                <div class="sign-line"></div>
                                <div class="sign-title">
                                    {{ $rightSignName ?? 'Nama Penandatangan Kanan' }}<br>
                                    <em>{{ $rightSignTitle }}</em>
                                </div>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="meta">
                Kode: {{ $code }}
            </div>

        </div>
    </div>
</div>
</body>
</html>
