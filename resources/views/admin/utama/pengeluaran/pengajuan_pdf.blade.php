@php
function terbilang($angka)
{
$angka = abs($angka);
$baca = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");

if ($angka < 12) {
    return " " . $baca[$angka];
    } else if ($angka < 20) {
    return terbilang($angka - 10) . " belas" ;
    } else if ($angka < 100) {
    return terbilang($angka / 10) . " puluh" . terbilang($angka % 10);
    } else if ($angka < 200) {
    return " seratus" . terbilang($angka - 100);
    } else if ($angka < 1000) {
    return terbilang($angka / 100) . " ratus" . terbilang($angka % 100);
    } else if ($angka < 2000) {
    return " seribu" . terbilang($angka - 1000);
    } else if ($angka < 1000000) {
    return terbilang($angka / 1000) . " ribu" . terbilang($angka % 1000);
    } else if ($angka < 1000000000) {
    return terbilang($angka / 1000000) . " juta" . terbilang($angka % 1000000);
    }
    }
    @endphp
    <!DOCTYPE html>
    <html>

    <head>
        <title>Laporan Pengeluaran</title>

        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }

            .kop {
                width: 100%;
                border-bottom: 3px solid black;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .logo {
                width: 90px;
            }

            .kop-text {
                text-align: center;
            }

            .kop-text h2 {
                margin: 0;
            }

            .kop-text p {
                margin: 2px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }

            th,
            td {
                padding: 8px;
            }

            th {
                background: #f2f2f2;
            }

            .title {
                text-align: center;
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .ttd {
                width: 100%;
                margin-top: 60px;
            }

            .ttd td {
                border: none;
                text-align: center;
            }
        </style>

    </head>

    <body>

        <!-- KOP SURAT -->
        <table class="kop">
            <tr>

                <td style="width:120px;">
                    <img src="{{ public_path('template/assets/dist/img/logo_mahkota.png') }}" class="logo" width="90">
                </td>

                <td class="kop-text">
                    <h2>MAHKOTA TRIP</h2>
                    <p>Travel Umrah & Haji</p>
                    <p>Jl. Contoh Alamat No.123 Pekanbaru</p>
                    <p>Telp: 0812-xxxx-xxxx</p>
                </td>

            </tr>
        </table>


        <div class="title">
            <h3>FORM PERMINTAAN</h3>
        </div>


        <table>

            <tr>
                <th style="width:30%">Item</th>
                <td>{{ $pengeluaran->item }}</td>
            </tr>

            <tr>
                <th>Kuantiti</th>
                <td>{{ $pengeluaran->kuantiti }}</td>
            </tr>

            <tr>
                <th>Satuan</th>
                <td>{{ $pengeluaran->satuan ?? '-' }}</td>
            </tr>

            <tr>
                <th>Harga Satuan</th>
                <td>Rp {{ number_format($pengeluaran->harga_satuan,0,',','.') }}</td>
            </tr>

            <tr>
                <th>Total Pengeluaran</th>
                <td><strong>Rp {{ number_format($pengeluaran->total_harga,0,',','.') }}</strong></td>
            </tr>

            <tr>
                <th>Terbilang</th>
                <td><strong><em> {{ ucfirst(trim(terbilang($pengeluaran->total_harga))) }} rupiah </em></strong></td>
            </tr>

            <tr>
                <th>Dibuat Oleh</th>
                <td>{{ $pengeluaran->created_by }}</td>
            </tr>

            <tr>
                <th>Tanggal</th>
                <td>{{ date('d F Y') }}</td>
            </tr>

        </table>


        <!-- TANDA TANGAN -->

        <table class="ttd">

            <tr>

                <td>
                    Mengetahui,<br>
                    Manager Keuangan
                    <br><br>

                    @if($pengeluaran->validation_by)
                    <img src="{{ public_path('storage/ttd/superadmin/ttd_superadmin.png') }}" width="120">
                    <br>
                    <strong>{{ $pengeluaran->validation_by }}</strong>
                    @else
                    (____________________)
                    @endif
                </td>

                <td style="text-align:center;">
                    Dibuat Oleh,
                    <br><br>

                    @if($pengeluaran->verified_by)

                    <img src="{{ public_path('storage/ttd/admin/ttd_akbar.png') }}" width="120">
                    <br>

                    @else

                    <br><br><br>

                    @endif

                    <strong>{{ $pengeluaran->created_by }}</strong>

                </td>

            </tr>

        </table>


    </body>

    </html>