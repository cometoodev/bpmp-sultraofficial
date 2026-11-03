<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Export Laporan SKM ULT</title>
    <style>
        @page {
            margin: 20px 25px;
            size: A4 portrait;
        }
        body {
            font-family: sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }
        .kop-surat {
            border-bottom: 2px solid #000000;
            padding-bottom: 8px;
            margin-bottom: 12px;
            text-align: center;
        }
        .kop-instansi {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        .kop-balai {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 2px 0;
        }
        .kop-alamat {
            font-size: 7.5pt;
            color: #475569;
            margin: 0;
        }
        .judul-laporan {
            text-align: center;
            margin-bottom: 12px;
        }
        .judul-laporan h2 {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #0f172a;
        }
        .judul-laporan p {
            font-size: 8.5pt;
            color: #64748b;
            margin: 2px 0 0 0;
        }
        .meta-info {
            width: 100%;
            margin-bottom: 10px;
            font-size: 8.5pt;
        }
        .summary-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .summary-box td {
            border: 1px solid #333333;
            padding: 8px;
            text-align: center;
            background-color: #f8fafc;
        }
        .summary-value {
            font-size: 14pt;
            font-weight: bold;
            color: #0f172a;
        }
        .summary-label {
            font-size: 7.5pt;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .section-header {
            font-size: 9.5pt;
            font-weight: bold;
            color: #1e3a8a;
            margin: 12px 0 4px 0;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 12px;
        }
        th, td {
            border: 1px solid #333333;
            padding: 5px 7px;
            text-align: left;
            word-wrap: break-word;
            vertical-align: middle;
            font-size: 8.5pt;
        }
        th {
            background-color: #2563eb;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }
        tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .pedoman-box {
            border: 1px solid #333333;
            background-color: #f8fafc;
            padding: 6px 10px;
            font-size: 8pt;
            margin-top: 10px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: none;
            page-break-inside: avoid;
        }
        .signature-table td {
            border: none;
            font-size: 9pt;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    <div class="kop-surat">
        <div class="kop-instansi">Kementerian Pendidikan Dasar dan Menengah</div>
        <div class="kop-balai">Balai Penjaminan Mutu Pendidikan Provinsi Sulawesi Tenggara</div>
        <div class="kop-alamat">
            Jl. R.E. Martadinata No. 1, Mandonga, Kendari, Sulawesi Tenggara 93111 | Surel: bpmp.sultra@kemdikbud.go.id
        </div>
    </div>

    <!-- JUDUL DOKUMEN -->
    <div class="judul-laporan">
        <h2>Laporan Hasil Pengukuran Survei Kepuasan Masyarakat (SKM)</h2>
        <p>Unit Layanan Terpadu (ULT) Sesuai Permenpan RB No. 14 Tahun 2017</p>
    </div>

    <!-- METADATA -->
    <table class="meta-info" style="border: none; margin-top: 0;">
        <tr>
            <td style="border: none; padding: 0;">
                <strong>Dicetak Pada:</strong> {{ now()->locale('id')->translatedFormat('l, d F Y - H:i') }} WITA
                @if(!empty($tahun) || !empty($triwulan) || !empty($layanan))
                    &bull; <strong>Filter:</strong> Tahun {{ $tahun ?? 'Semua' }}
                    {{ !empty($triwulan) ? '(Triwulan '.$triwulan.')' : '' }}
                    {{ !empty($layanan) ? '— Layanan: '.$layanan : '' }}
                @endif
            </td>
            <td style="border: none; padding: 0; text-align: right;">
                <strong>Total Responden:</strong> {{ $demographics['total'] ?? 0 }} Orang
            </td>
        </tr>
    </table>

    <!-- RINGKASAN HASIL IKM -->
    <table class="summary-box">
        <tr>
            <td style="width: 25%;">
                <div class="summary-value">{{ number_format($totalIkm, 2) }}</div>
                <div class="summary-label">Nilai IKM Konversi</div>
            </td>
            <td style="width: 25%;">
                <div class="summary-value" style="color: #1e3a8a;">Mutu {{ $mutuLayanan['grade'] }}</div>
                <div class="summary-label">Mutu Pelayanan</div>
            </td>
            <td style="width: 25%;">
                <div class="summary-value" style="color: #047857;">{{ $mutuLayanan['label'] }}</div>
                <div class="summary-label">Kategori Kinerja</div>
            </td>
            <td style="width: 25%;">
                <div class="summary-value">{{ number_format($totalNrt, 4) }}</div>
                <div class="summary-label">Total NRT Tertimbang</div>
            </td>
        </tr>
    </table>

    <!-- 1. TABEL NILAI IKM PER UNSUR PELAYANAN (P1 - P9) -->
    <div class="section-header">1. Rekapitulasi Nilai Per Unsur Pelayanan (P1 - P9)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 35px;">Kode</th>
                <th>Unsur Pelayanan</th>
                <th style="width: 100px;">Nilai Rata-rata (NR)</th>
                <th style="width: 70px;">Bobot</th>
                <th style="width: 110px;">Nilai Tertimbang (NRT)</th>
            </tr>
        </thead>
        <tbody>
            @php $p = 1; @endphp
            @foreach($ikmPerUnsur as $key => $unsur)
                <tr>
                    <td class="text-center font-bold">P{{ $p++ }}</td>
                    <td><strong>{{ $unsur['label'] }}</strong></td>
                    <td class="text-center font-bold">{{ number_format($unsur['nr'], 3) }}</td>
                    <td class="text-center">0.111</td>
                    <td class="text-center font-bold">{{ number_format($unsur['nrt'], 4) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #e2e8f0; font-weight: bold;">
                <td colspan="4" class="text-right">TOTAL NILAI RATA-RATA TERTIMBANG (NRT):</td>
                <td class="text-center" style="font-size: 9pt;">{{ number_format($totalNrt, 4) }}</td>
            </tr>
            <tr style="background-color: #dbeafe; font-weight: bold;">
                <td colspan="4" class="text-right">NILAI INDEKS KEPUASAN MASYARAKAT (IKM) KONVERSI = NRT &times; 25:</td>
                <td class="text-center" style="font-size: 10pt; color: #1e3a8a;">{{ number_format($totalIkm, 2) }}</td>
            </tr>
            <tr style="background-color: #f1f5f9; font-weight: bold;">
                <td colspan="4" class="text-right">PREDIKAT MUTU &amp; KINERJA PELAYANAN:</td>
                <td class="text-center" style="font-size: 9pt; color: #047857;">MUTU {{ $mutuLayanan['grade'] }} ({{ $mutuLayanan['label'] }})</td>
            </tr>
        </tfoot>
    </table>

    <!-- 2. TABEL AKUMULASI IKM PER JENIS LAYANAN -->
    <div class="section-header">2. Akumulasi IKM Per Jenis Layanan</div>
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Jenis Layanan</th>
                <th style="width: 90px;">Jumlah Responden</th>
                <th style="width: 90px;">IKM Konversi</th>
                <th style="width: 60px;">Mutu</th>
                <th style="width: 95px;">Kinerja</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ikmPerLayanan as $idx => $row)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td><strong>{{ $row['layanan'] }}</strong></td>
                    <td class="text-center">{{ $row['responden'] }}</td>
                    <td class="text-center font-bold">{{ number_format($row['ikm'], 2) }}</td>
                    <td class="text-center font-bold">{{ $row['grade'] }}</td>
                    <td class="text-center">{{ $row['label'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 10px; color: #64748b;">
                        Belum ada data IKM per layanan yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- PEDOMAN MUTU PERMENPAN RB -->
    <div class="pedoman-box">
        <strong>Pedoman Skala Penilaian SKM (Permenpan RB No. 14 Tahun 2017):</strong><br>
        &bull; <strong>Mutu A (Sangat Baik):</strong> 88.31 &ndash; 100.00 &nbsp;|&nbsp;
        &bull; <strong>Mutu B (Baik):</strong> 76.61 &ndash; 88.30 &nbsp;|&nbsp;
        &bull; <strong>Mutu C (Kurang Baik):</strong> 65.00 &ndash; 76.60 &nbsp;|&nbsp;
        &bull; <strong>Mutu D (Tidak Baik):</strong> 25.00 &ndash; 64.99
    </div>

    <!-- TANDA TANGAN / PENGESAHAN -->
    <table class="signature-table">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: center;">
                Kendari, {{ now()->locale('id')->translatedFormat('d F Y') }}<br>
                Kepala Balai Penjaminan Mutu Pendidikan<br>
                Provinsi Sulawesi Tenggara<br><br><br><br>
                <strong><u>Pimpinan BPMP Provinsi Sulawesi Tenggara</u></strong><br>
                NIP. ........................................
            </td>
        </tr>
    </table>

</body>
</html>
