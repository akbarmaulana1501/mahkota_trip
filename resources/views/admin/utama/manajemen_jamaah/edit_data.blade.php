<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ auth()->user()->username }} | Amanah Travel</title>

    <!-- Google Font: Source Sans Pro -->
    @include('layouts.style')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->


                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->


            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            @include('layouts.logo_dash')

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                @include('layouts.user')
                @if (session('successUpdatePassword'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Password Berhasil diperbarui!",
                        showConfirmButton: true,
                    });
                </script>
                @endif

                @if (session('success_pembayaran_cicilan'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Pembayaran Berhasil ditambahkan!",
                        showConfirmButton: true,
                    });
                </script>
                @endif
                <!-- SidebarSearch Form -->
                <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->
                @include('layouts.sidebar')
            </div>
            <!-- /.sidebar -->
        </aside>
        @include('layouts.modals_user')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">

                            <!-- /.card -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Jamaah</h3>
                                </div>

                                <form action="{{ route('jamaah.update', $jamaah->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body">
                                        <h4 class="mb-2">A. Data Pribadi</h4>

                                        <div class="form-group">
                                            <label>Nama Depan</label>
                                            <input type="text" name="nama_depan" class="form-control"
                                                value="{{ $jamaah->nama_depan }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Nama Belakang</label>
                                            <input type="text" name="nama_belakang" class="form-control"
                                                value="{{ $jamaah->nama_belakang }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Nama Ayah</label>
                                            <input type="text" name="nama_ayah" class="form-control"
                                                value="{{ $jamaah->nama_ayah }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-control" required>
                                                <option value="L" {{ $jamaah->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                                <option value="P" {{ $jamaah->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" class="form-control"
                                                value="{{ $jamaah->tanggal_lahir }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir" value="{{ $jamaah->tempat_lahir }}" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Status Pernikahan</label>
                                            <select name="status_pernikahan" class="form-control" required>
                                                <option value="" disabled {{ $jamaah->status_pernikahan === null ? 'selected' : '' }}>Pilih</option>
                                                <option value="0" {{ $jamaah->status_pernikahan == 0 ? 'selected' : '' }}>Belum Menikah</option>
                                                <option value="1" {{ $jamaah->status_pernikahan == 1 ? 'selected' : '' }}>Menikah</option>
                                                <option value="2" {{ $jamaah->status_pernikahan == 2 ? 'selected' : '' }}>Janda / Duda</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Pekerjaan</label>
                                            <select name="pekerjaan" class="form-control" required>
                                                <option value="">-- Pilih Pekerjaan --</option>
                                                @foreach($pekerjaan as $p)
                                                <option value="{{ $p->nama_pekerjaan }}" {{ $jamaah->pekerjaan == $p->nama_pekerjaan ? 'selected' : '' }}>
                                                    {{ $p->nama_pekerjaan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Pendidikan</label>
                                            <select name="pendidikan" class="form-control" required>
                                                <option value="" disabled {{ $jamaah->pendidikan === null ? 'selected' : '' }}>-- Pilih pendidikan --</option>
                                                <option value="1" {{ $jamaah->pendidikan == 1 ? 'selected' : '' }}>SD</option>
                                                <option value="2" {{ $jamaah->pendidikan == 2 ? 'selected' : '' }}>SMP</option>
                                                <option value="3" {{ $jamaah->pendidikan == 3 ? 'selected' : '' }}>SMA</option>
                                                <option value="4" {{ $jamaah->pendidikan == 4 ? 'selected' : '' }}>D4/S1</option>
                                                <option value="5" {{ $jamaah->pendidikan == 5 ? 'selected' : '' }}>S2</option>
                                                <option value="6" {{ $jamaah->pendidikan == 6 ? 'selected' : '' }}>S3</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Email (Opsional)</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $jamaah->email }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Alamat Lengkap</label>
                                            <textarea name="alamat_lengkap" class="form-control" rows="2">{{ $jamaah->alamat_lengkap }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>No Telepon</label>
                                            <input type="number" name="kontak_darurat_nama" class="form-control"
                                                value="{{ $jamaah->kontak_darurat_nama }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>No Telepon Darurat</label>
                                            <input type="number" name="kontak_darurat_hp" class="form-control"
                                                value="{{ $jamaah->kontak_darurat_hp }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Paket Keberangkatan</label>
                                            <select name="paket_id" class="form-control" required>
                                                @foreach($paket as $p)
                                                <option value="{{ $p->id }}" {{ $jamaah->paket_id == $p->id ? 'selected' : '' }}>
                                                    {{ $p->nama_paket }} - {{ $p->harga_paket }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Tanggal Keberangkatan</label>
                                            <input type="date" name="tgl_keberangkatan" class="form-control" value="{{ $jamaah->tgl_keberangkatan }}">
                                        </div>

                                        <hr>
                                        <h4>B. Passport</h4>

                                        <div class="form-group">
                                            <label>Apakah sudah memiliki Passport?</label>
                                            <select name="status_passport" id="status_passport" class="form-control" required>
                                                <option value="sudah" {{ $jamaah->status_passport == 'sudah' ? 'selected' : '' }}>Sudah</option>
                                                <option value="belum" {{ $jamaah->status_passport == 'belum' ? 'selected' : '' }}>Belum</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Nomor KTP</label>
                                            <input type="number" name="no_ktp" class="form-control" value="{{ $jamaah->no_ktp ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Upload Foto KTP</label>
                                            <input type="file" name="foto_ktp" class="form-control">
                                            @if($jamaah->foto_ktp)
                                            <a href="{{ asset('storage/' . $jamaah->foto_ktp) }}" target="_blank">Lihat file saat ini</a>
                                            @else
                                            <span class="text-danger">File belum ada</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label>Upload Foto KK</label>
                                            <input type="file" name="foto_kk" class="form-control">
                                            @if($jamaah->foto_kk)
                                            <a href="{{ asset('storage/' . $jamaah->foto_kk) }}" target="_blank">Lihat file saat ini</a>
                                            @else
                                            <span class="text-danger">File belum ada</span>
                                            @endif
                                        </div>

                                        <div id="berkas_passport_sudah" style="display:none;">
                                            <div class="form-group">
                                                <label>Upload Foto Passport (halaman 4 bagian data diri)</label>
                                                <input type="file" name="foto_paspor" class="form-control">
                                                @if($jamaah->foto_paspor)
                                                <a href="{{ asset('storage/' . $jamaah->foto_paspor) }}" target="_blank">Lihat file saat ini</a>
                                                @else
                                                <span class="text-danger">File belum ada</span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label>Nomor Paspor</label>
                                                <input type="number" name="no_paspor" class="form-control" value="{{ $jamaah->no_pasport ?? '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Terbit</label>
                                                <input type="date" name="tgl_terbit" class="form-control" value="{{ $jamaah->tgl_terbit ?? '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Expire</label>
                                                <input type="date" name="tgl_exp" class="form-control" value="{{ $jamaah->tgl_exp ?? '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Daerah Penerbitan</label>
                                                <input type="text" name="daerah_penerbitan" class="form-control" value="{{ $jamaah->daerah_terbit ?? '' }}">
                                            </div>
                                        </div>

                                        <div id="berkas_passport_belum" style="display:none;">
                                            <div class="form-group">
                                                <label>Akte Kelahiran/Buku Nikah/Ijazah</label>
                                                <input type="file" name="foto_akte" class="form-control">
                                                @if($jamaah->foto_akte)
                                                <a href="{{ asset('storage/' . $jamaah->foto_akte) }}" target="_blank">Lihat file saat ini</a>
                                                @endif
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {

                                                const statusPassport = document.getElementById("status_passport");
                                                const sudah = document.getElementById("berkas_passport_sudah");
                                                const belum = document.getElementById("berkas_passport_belum");

                                                const noPaspor = document.querySelector("input[name='no_paspor']");
                                                const fotoPaspor = document.querySelector("input[name='foto_paspor']");
                                                const tgl_terbit = document.querySelector("input[name='tgl_terbit']");
                                                const tgl_exp = document.querySelector("input[name='tgl_exp']");
                                                const daerah_terbit = document.querySelector("input[name='daerah_penerbitan']");
                                                
                                                const fotoAkte = document.querySelector("input[name='foto_akte']");

                                                function toggleBerkasPassport() {

                                                    if (statusPassport.value === "sudah") {

                                                        sudah.style.display = "block";
                                                        belum.style.display = "none";

                                                        noPaspor.required = true;
                                                        fotoAkte.required = false;
                                                        tgl_terbit.required = true;
                                                        tgl_exp.required = true;
                                                        daerah_terbit.required = true;

                                                    } else {

                                                        sudah.style.display = "none";
                                                        belum.style.display = "block";

                                                        noPaspor.required = false;
                                                        fotoPaspor.required = false;
                                                        fotoAkte.required = true;
                                                    }
                                                }

                                                statusPassport.addEventListener("change", toggleBerkasPassport);

                                                toggleBerkasPassport();
                                            });
                                        </script>

                                        <hr>
                                        <h4>C. Vaksinasi</h4>

                                        <div class="form-group">
                                            <label>Apakah sudah vaksin meningitis?</label>
                                            <select id="status_vaksin_meningitis" name="status_vaksin_meningitis" class="form-control" required>
                                                <option value="sudah" {{ $jamaah->status_vaksin_meningitis == 'sudah' ? 'selected' : '' }}>Sudah</option>
                                                <option value="belum" {{ $jamaah->status_vaksin_meningitis == 'belum' ? 'selected' : '' }}>Belum</option>
                                            </select>
                                        </div>

                                        <div id="sudah_vaksin" style="display: none;">
                                            <div class="form-group">
                                                <label>Surat Vaksin</label>
                                                <input type="file" name="foto_vaksin" class="form-control">
                                                @if($jamaah->foto_vaksin)
                                                <a href="{{ asset('storage/' . $jamaah->foto_vaksin) }}" target="_blank">Lihat Surat Vaksin Saat Ini</a>
                                                @endif
                                            </div>
                                        </div>

                                        <script>
                                            function toggleVaksin() {
                                                const val = document.getElementById("status_vaksin_meningitis").value;
                                                document.getElementById("sudah_vaksin").style.display = val === "sudah" ? "block" : "none";
                                            }

                                            document.getElementById("status_vaksin_meningitis").addEventListener("change", toggleVaksin);

                                            // Jalankan saat halaman load agar sesuai data edit
                                            toggleVaksin();
                                        </script>

                                        <hr>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>

                                </form>
                            </div>

                            <!-- /.card -->
                        </div>
                        <div class="col-6">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Riwayat Pembayaran</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahPembayaran">
                                            <i class="fa fa-plus"></i> Tambah Pembayaran
                                        </a>
                                    </div>

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nominal</th>
                                                <th class="text-center">status</th>
                                                <th class="text-center">Bukti</th>
                                                <th class="text-center">Tanggal & Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($riwayat_pembayaran as $index => $rp)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>Rp {{ number_format($rp->amount, 0, ',', '.') }}</td>
                                                <td class="text-center">
                                                    @if($rp->status == "paid")
                                                    <span class="badge bg-success">Success</span>
                                                    @elseif($rp->status == "pending")
                                                    <span class="badge bg-warning">Pending</span>
                                                    @elseif($rp->status == "failed")
                                                    <span class="badge bg-danger">Failed</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($rp->bukti_pembayaran)
                                                    <a href="{{ asset('storage/' . $rp->bukti_pembayaran) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-info"
                                                        title="Lihat Bukti">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{$rp->waktu}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="modal fade" id="modalTambahPembayaran">
                            <div class="modal-dialog">
                                <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="jamaah_id" value="{{ $jamaah->id }}">

                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h4 class="modal-title">Tambah Pembayaran</h4>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">

                                            <!-- Nominal -->
                                            <div class="form-group">
                                                <label>Nominal Pembayaran</label>
                                                <input type="text" id="rupiah" class="form-control" placeholder="Masukan nominal">
                                                <input type="hidden" name="amount" id="amount">
                                            </div>
                                            <div class="form-group">
                                                <label>Bukti Pembayaran</label>
                                                <input type="file" name="bukti_pembayaran" class="form-control" required>
                                                <small class="text-muted">
                                                    * Ukuran file minimal 2 MB
                                                </small>
                                            </div>


                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    @include('layouts.script')

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('bukti_bayar_dp_input');
            const nominalOutput = document.getElementById('nominal_output');
            const nominalOutput2 = document.getElementById('nominal_output2');

            // Fungsi untuk membersihkan dan memformat nominal dari OCR
            function cleanAndFormatNominal(text) {
                const nominalRegex = /Rp\s*([\d.,]+)/gi;
                let matches = Array.from(text.matchAll(nominalRegex));

                if (matches.length === 0) return 'Nominal tidak ditemukan.';

                let highestValue = 0;
                for (const match of matches) {
                    let numStr = match[1].replace(/\./g, '').replace(/,/g, '.');
                    let value = parseFloat(numStr);
                    if (!isNaN(value) && value > highestValue) highestValue = value;
                }

                return `Rp ${highestValue.toLocaleString('id-ID')}`;
            }

            function cleanAndGetNumber(text) {
                const nominalRegex = /Rp\s*([\d.,]+)/gi;
                let matches = Array.from(text.matchAll(nominalRegex));

                if (matches.length === 0) return null;

                let highestValue = 0;
                for (const match of matches) {
                    let numStr = match[1].replace(/\./g, '').replace(/,/g, '.');
                    let value = parseFloat(numStr);
                    if (!isNaN(value) && value > highestValue) highestValue = value;
                }

                return highestValue; // angka saja
            }

            // Fungsi utama OCR
            async function runOCR(imageFile) {
                // Tampilkan loading SweetAlert
                Swal.fire({
                    title: 'Memproses OCR...',
                    text: 'Tunggu sebentar, ini bisa memakan beberapa detik.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                nominalOutput.value = '';
                nominalOutput.style.backgroundColor = 'yellow';

                const worker = await Tesseract.createWorker();

                await worker.loadLanguage('eng+ind');
                await worker.initialize('eng+ind');

                await worker.setParameters({
                    tessedit_char_whitelist: '0123456789.,Rp'
                });

                const {
                    data: {
                        text
                    }
                } = await worker.recognize(imageFile);
                await worker.terminate();

                // console.log("Teks Hasil OCR:", text);

                const detectedNominal = cleanAndFormatNominal(text);
                const detectedNominal2 = cleanAndGetNumber(text);

                // Tampilkan hasil di input
                nominalOutput.value = detectedNominal;
                nominalOutput2.value = detectedNominal2;
                nominalOutput.style.backgroundColor = detectedNominal.includes('Nominal') ? '#dc2626' : '#10b981';

                // Tutup loading SweetAlert
                Swal.close();

                // Bisa juga tampilkan hasil akhir dengan alert
                Swal.fire({
                    icon: detectedNominal.includes('Nominal') ? 'error' : 'success',
                    title: 'OCR Selesai',
                    html: `Nominal Dideteksi: <b>${detectedNominal}</b>`,
                });
            }

            // Event listener input file
            fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) runOCR(file);
            });
        });
    </script>

    <script>
        document.getElementById('rupiah').addEventListener('keyup', function(e) {

            let angka = this.value.replace(/[^,\d]/g, '').toString();
            let split = angka.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            this.value = rupiah ? 'Rp ' + rupiah : '';

            // Simpan angka asli ke hidden input
            document.getElementById('amount').value = angka;
        });
    </script>
</body>

</html>