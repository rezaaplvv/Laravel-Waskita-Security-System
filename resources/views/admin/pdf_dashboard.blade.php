<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Operasional Keamanan - PT Waskita Angkasa Satya</title>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .text-uppercase { text-transform: uppercase; }
        
        .header {
            border-bottom: 2px solid #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #555;
        }

        .meta-info {
            width: 100%;
            margin-bottom: 20px;
        }
        .meta-info td {
            vertical-align: top;
        }

        .stats-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .stats-grid td {
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .stats-grid .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            display: block;
            margin-top: 5px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ccc;
            padding: 6px 8px;
        }
        table.data-table th {
            background-color: #f3f3f3;
            font-weight: bold;
            text-align: left;
        }

        .signature-box {
            width: 300px;
            float: right;
            text-align: center;
            margin-top: 40px;
        }
        .signature-name {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="header text-center">
        <h1 class="text-uppercase font-bold">PT WASKITA ANGKASA SATYA</h1>
        <p>Laporan Operasional Keamanan</p>
    </div>

    <!-- META INFO -->
    <table class="meta-info">
        <tr>
            <td style="width: 120px;"><strong>Tanggal Cetak</strong></td>
            <td>: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Dicetak Oleh</strong></td>
            <td>: {{ Auth::user()->name }} (Administrator)</td>
        </tr>
    </table>

    <!-- STATISTIK UTAMA -->
    <div class="section-title">1. RINGKASAN STATISTIK UTAMA</div>
    <table class="stats-grid">
        <tr>
            <td>
                Total Personel
                <span class="stat-value">{{ $totalPersonel }}</span>
            </td>
            <td>
                Lokasi/Klien Aktif
                <span class="stat-value">{{ $totalKlien }}</span>
            </td>
            <td>
                Laporan Hari Ini
                <span class="stat-value">{{ $laporanHariIni }}</span>
            </td>
            <td>
                Insiden Kritis
                <span class="stat-value">{{ $insidenHariIni }}</span>
            </td>
        </tr>
    </table>

    <!-- MANIFES KEHADIRAN -->
    <div class="section-title">2. DAFTAR PERSONEL MASUK HARI INI</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Nama Personel</th>
                <th style="width: 15%;">NIP</th>
                <th style="width: 35%;">Lokasi Penempatan</th>
                <th style="width: 15%; text-align: center;">Jam Masuk</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $absen)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $absen->personel->nama_lengkap }}</td>
                <td>{{ $absen->personel->nip }}</td>
                <td>{{ optional($absen->personel->client)->nama_perusahaan ?? 'Belum ada klien' }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada personel yang melakukan absensi hari ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- LOG INSIDEN -->
    <div class="section-title">3. DAFTAR LAPORAN / INSIDEN HARI INI</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Nama Personel</th>
                <th style="width: 25%;">Lokasi Klien</th>
                <th style="width: 15%;">Tipe Laporan</th>
                <th style="width: 30%;">Deskripsi Laporan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $report)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ optional($report->personel)->nama_lengkap ?? 'Unknown' }}</td>
                <td>{{ optional($report->client)->nama_perusahaan ?? (optional($report->personel->client)->nama_perusahaan ?? 'Belum ada klien') }}</td>
                <td class="text-uppercase">{{ $report->tipe_laporan }}</td>
                <td>{{ $report->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada laporan atau insiden yang masuk hari ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <div class="clearfix">
        <div class="signature-box">
            <p>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p style="margin-bottom: 5px;">Mengetahui,</p>
            <p><strong>Manajer Operasional PT Waskita Angkasa Satya</strong></p>
            
            <!-- Tempat Tanda Tangan -->
            <div class="signature-name">Nama Terang Manajer</div>
        </div>
    </div>

</body>
</html>