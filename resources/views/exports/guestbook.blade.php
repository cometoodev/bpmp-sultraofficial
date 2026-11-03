<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Export Laporan Buku Tamu</title>
    <style>
        @page {
            margin: 15px 20px;
            size: A4 landscape;
        }
        body {
            font-family: sans-serif;
            font-size: 9px;
            color: #1e293b;
            line-height: 1.3;
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
            margin-bottom: 10px;
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
            margin-bottom: 8px;
            font-size: 8pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #333333;
            padding: 5px 6px;
            text-align: left;
            word-wrap: break-word;
            vertical-align: top;
            font-size: 8pt;
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
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: none;
            page-break-inside: avoid;
        }
        .signature-table td {
            border: none;
            font-size: 8.5pt;
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
        <h2>Rekapitulasi Buku Tamu &amp; Kuisioner Layanan</h2>
        <p>Unit Layanan Terpadu (ULT) BPMP Provinsi Sulawesi Tenggara</p>
    </div>

    <!-- METADATA LAPORAN -->
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
                <strong>Total Kunjungan:</strong> {{ $guestbooks->count() }} Data
            </td>
        </tr>
    </table>

    <!-- TABEL DATA BUKU TAMU -->
    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 75px;">Tanggal / Waktu</th>
                <th style="width: 110px;">Nama Pengunjung</th>
                <th style="width: 25px;">L/P</th>
                <th style="width: 30px;">Usia</th>
                <th style="width: 70px;">Pendidikan</th>
                <th style="width: 80px;">Pekerjaan</th>
                <th style="width: 120px;">Instansi / Asal Kab.</th>
                <th style="width: 75px;">No. Telepon</th>
                <th style="width: 110px;">Jenis Layanan</th>
                <th style="width: 40px;">Skor</th>
                <th>Saran / Masukan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guestbooks as $index => $item)
                @php
                    $survey = $item->ultSurveyResponse;
                    $avgScore = null;
                    if ($survey) {
                        $avgScore = round(($survey->q1 + $survey->q2 + $survey->q3 + $survey->q4 + $survey->q5 + $survey->q6 + $survey->q7 + $survey->q8 + $survey->q9) / 9, 2);
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td class="text-center">{{ $item->jenis_kelamin }}</td>
                    <td class="text-center">{{ $item->usia }} Th</td>
                    <td>{{ $item->pendidikan }}</td>
                    <td>{{ $item->pekerjaan }}</td>
                    <td>
                        {{ $item->asal_instansi }}<br>
                        <span style="color: #64748b; font-size: 7pt;">Kab/Kota: {{ $item->asal_kabupaten }}</span>
                    </td>
                    <td>{{ $item->telepon ?? '-' }}</td>
                    <td>{{ $item->jenis_layanan }}</td>
                    <td class="text-center font-bold">
                        {{ $avgScore !== null ? number_format($avgScore, 2) : '-' }}
                    </td>
                    <td>
                        {{ ($survey && !empty($survey->saran)) ? $survey->saran : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center" style="padding: 12px; color: #64748b;">
                        Belum ada data kunjungan buku tamu yang tercatat.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN / PENGESAHAN -->
    <table class="signature-table">
        <tr>
            <td style="width: 65%;"></td>
            <td style="width: 35%; text-align: center;">
                Kendari, {{ now()->locale('id')->translatedFormat('d F Y') }}<br>
                Penanggung Jawab Layanan Terpadu (ULT)<br>
                BPMP Provinsi Sulawesi Tenggara<br><br><br><br>
                <strong><u>Administrator ULT</u></strong><br>
                NIP. ........................................
            </td>
        </tr>
    </table>

</body>
</html>
