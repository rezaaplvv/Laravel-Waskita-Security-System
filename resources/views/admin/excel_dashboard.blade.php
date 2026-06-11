<table>
    <thead>
        <tr>
            <th colspan="4" style="font-weight: bold; text-align: center; font-size: 16px;">LAPORAN OPERASIONAL KEAMANAN</th>
        </tr>
        <tr>
            <th colspan="4" style="font-weight: bold; text-align: center;">PT WASKITA ANGKASA SATYA</th>
        </tr>
        <tr>
            <th colspan="4" style="text-align: center;">Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}</th>
        </tr>
        <tr>
            <th colspan="4"></th>
        </tr>
    </thead>
</table>

<table>
    <thead>
        <tr>
            <th colspan="4" style="font-weight: bold;">1. RINGKASAN STATISTIK UTAMA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #f3f4f6;">Total Personel</th>
            <th style="font-weight: bold; background-color: #f3f4f6;">Total Lokasi/Klien Aktif</th>
            <th style="font-weight: bold; background-color: #f3f4f6;">Laporan Hari Ini</th>
            <th style="font-weight: bold; background-color: #f3f4f6;">Insiden Kritis Hari Ini</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center;">{{ $totalPersonel }}</td>
            <td style="text-align: center;">{{ $totalKlien }}</td>
            <td style="text-align: center;">{{ $laporanHariIni }}</td>
            <td style="text-align: center;">{{ $insidenHariIni }}</td>
        </tr>
    </tbody>
</table>

<table>
    <tr>
        <td colspan="4"></td>
    </tr>
    <tr>
        <th colspan="4" style="font-weight: bold;">2. DAFTAR PERSONEL MASUK HARI INI</th>
    </tr>
    <tr>
        <th style="font-weight: bold; background-color: #f3f4f6;">Nama Personel</th>
        <th style="font-weight: bold; background-color: #f3f4f6;">NIP</th>
        <th style="font-weight: bold; background-color: #f3f4f6;">Lokasi Penempatan</th>
        <th style="font-weight: bold; background-color: #f3f4f6;">Jam Masuk</th>
    </tr>
    @forelse($attendances as $absen)
        <tr>
            <td>{{ $absen->personel->nama_lengkap }}</td>
            <td>{{ $absen->personel->nip }}</td>
            <td>{{ optional($absen->personel->client)->nama_perusahaan ?? 'Belum ada klien' }}</td>
            <td>{{ \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align: center;">Belum ada personel yang melakukan absensi hari ini.</td>
        </tr>
    @endforelse
</table>

<table>
    <tr>
        <td colspan="4"></td>
    </tr>
    <tr>
        <th colspan="4" style="font-weight: bold;">3. DAFTAR LAPORAN / INSIDEN HARI INI</th>
    </tr>
    <tr>
        <th style="font-weight: bold; background-color: #f3f4f6;">Nama Personel</th>
        <th style="font-weight: bold; background-color: #f3f4f6;">Lokasi Klien</th>
        <th style="font-weight: bold; background-color: #f3f4f6;">Tipe Laporan</th>
        <th style="font-weight: bold; background-color: #f3f4f6;">Deskripsi Laporan</th>
    </tr>
    @forelse($reports as $report)
        <tr>
            <td>{{ $report->personel->nama_lengkap }}</td>
            <td>{{ optional($report->client)->nama_perusahaan ?? (optional($report->personel->client)->nama_perusahaan ?? 'Belum ada klien') }}</td>
            <td>{{ ucfirst($report->tipe_laporan) }}</td>
            <td>{{ $report->keterangan }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align: center;">Belum ada laporan atau insiden yang masuk hari ini.</td>
        </tr>
    @endforelse
</table>