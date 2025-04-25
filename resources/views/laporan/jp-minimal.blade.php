<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan JP Minimal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
            height: auto;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 0px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px 0px;
            vertical-align: top;
        }
        .info-label {
            font-weight: bold;
            width: 80px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            /* border: 1px solid black; */
            margin-top: 20px;
        }
        .signature-table td {
            /* border: 1px solid black; */
            width: 50%;
            vertical-align: top;
            text-align: center;
            padding: 0px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 0px;
        }
        table.data-table, .data-table th, .data-table td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .print-time {
            text-align: left;
            margin-bottom: 0px;
        }
    </style>
</head>
<body>

    <!-- Header Laporan -->
    <div class="header">
        <!-- <img src="{{ public_path('logo.png') }}" alt="Logo"> -->
        <div class="title">Rekapitulasi JP Widyaiswara</div>
    </div>

    <!-- Informasi Pegawai dalam tabel tanpa border -->
    <table class="info-table">
        <tr>
            <td class="info-label">NIP</td>
            <td>: {{ $fasilitator->nip }}</td>
            <td class="info-label">Bulan</td>
            <td>: {{ $bulan }}</td>
        </tr>
        <tr>
            <td class="info-label">Nama</td>
            <td>: {{ $fasilitator->nama }}</td>
            <td class="info-label">Tahun</td>
            <td>: {{ $tahun }}</td>
        </tr>
    </table>

    <!-- Tabel Bukan JP Minimal -->
    <h3>Tidak Termasuk Perhitungan</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jadwal</th>
                <th>Mata Pelatihan</th>
                <th>JP</th>
            </tr>
        </thead>
        <tbody>
            @if (count($kategori[0]) > 0)
                @foreach ($kategori[0] as $key => $item)
                    <tr>
                        <td style="text-align: center; width: 20px;">{{ $key + 1 }}</td>
                        <td style="text-align: center; width: 75px;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->jid_nama }}</td>
                        <td>{{ $item->nama_mapel }}</td>
                        <td style="text-align: right; width: 40px;">{{ $item->jp }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center;"><strong>Tidak ada.</strong></td>
                </tr>
            @endif
        </tbody>
        @if (count($kategori[0]) > 0)
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: center;"><strong>Total</strong></td>
                    <td style="text-align: right;"><strong>{{ array_sum(array_column($kategori[0], 'jp')) }}</strong></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Tabel JP Minimal -->
    <h3>Perhitungan JP Minimal</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jadwal</th>
                <th>Mata Pelatihan</th>
                <th>JP</th>
            </tr>
        </thead>
        <tbody>
            @if (count($kategori[1]) > 0)
                @foreach ($kategori[1] as $key => $item)
                    <tr>
                        <td style="text-align: center; width: 20px;">{{ $key + 1 }}</td>
                        <td style="text-align: center; width: 75px;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->jid_nama }}</td>
                        <td>{{ $item->nama_mapel }}</td>
                        <td style="text-align: right; width: 40px;">{{ $item->jp }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center;"><strong>Tidak ada.</strong></td>
                </tr>
            @endif
        </tbody>
        @if (count($kategori[1]) > 0)
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: center;"><strong>Total</strong></td>
                    <td style="text-align: right;"><strong>{{ array_sum(array_column($kategori[1], 'jp')) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center;"><strong>Total JP - Jam Minimal ( {{ array_sum(array_column($kategori[1], 'jp')) }}JP - {{ $perbulan }}JP )</strong></td>
                    <td style="text-align: right;"><strong>{{  array_sum(array_column($kategori[1], 'jp')) - $perbulan }}</strong></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Tabel Dibayarkan -->
    <h3>Perhitungan Penuh</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jadwal</th>
                <th>Mata Pelatihan</th>
                <th>JP</th>
            </tr>
        </thead>
        <tbody>
            @if (count($kategori[2]) > 0)
                @foreach ($kategori[2] as $key => $item)
                    <tr>
                        <td style="text-align: center; width: 20px;">{{ $key + 1 }}</td>
                        <td style="text-align: center; width: 75px;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->jid_nama }}</td>
                        <td>{{ $item->nama_mapel }}</td>
                        <td style="text-align: right; width: 40px;">{{ $item->jp }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center;"><strong>Tidak ada.</strong></td>
                </tr>
            @endif
        </tbody>
        @if (count($kategori[2]) > 0)
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: center;"><strong>Total</strong></td>
                    <td style="text-align: right;"><strong>{{ array_sum(array_column($kategori[2], 'jp')) }}</strong></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Footer -->
    <div>
        <div>
            <p>
                <strong>KETENTUAN JAM MINIMAL (SK GUB KALTIM 893/K.158/2021)</strong> <br />
                Pembayaran honorarium hanya dibayarkan pada bulan berjalan.
            </p>
        </div>

        <div class="print-time">
            <p>
                <strong>Dicetak pada:</strong> {{ now()->format('d-m-Y H:i') }} <br />
                <strong>oleh:</strong> {{ auth()->user()->name }}
            </p>
        </div>

        <!-- Tanda tangan sejajar kanan kiri -->
        <table class="signature-table">
            <tr>
                <td style="padding: 0px 60px; margin-bottom: 100px; height: 120px;">
                    Telah sesuai dengan yang dilaksanakan <br />
                    Widyaiswara
                </td>
                <td style="padding: 0px 60px; margin-bottom: 100px;">
                    {{ $tandatangan['jabatan'] }}
                </td>
            </tr>
            <tr>
                <td><strong>( {{ $fasilitator->nama }} )</strong></td=>
                <td><strong>( {{ $tandatangan['nama'] }} )</strong></td>
            </tr>
            <tr>
                <td>NIP. {{ $fasilitator->nip }}</td=>
                <td>NIP. {{ $tandatangan['nip'] }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
