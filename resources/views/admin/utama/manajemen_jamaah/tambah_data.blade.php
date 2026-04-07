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

                                <form action="{{ route('jamaah.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <h4 class="mb-2">A. Data Pribadi</h4>
                                        <div class="form-group">
                                            <label>Nama Depan</label>
                                            <input type="text" name="nama_depan" class="form-control" placeholder="Nama depan" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Belakang</label>
                                            <input type="text" name="nama_belakang" class="form-control" placeholder="Nama belakang" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Nama Ayah</label>
                                            <input type="text" name="nama_ayah" class="form-control" placeholder="Nama ayah" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-control" required>
                                                <option value="" disabled selected>Pilih</option>
                                                <option value="L">Laki-Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Status Pernikahan</label>
                                            <select name="status_pernikahan" class="form-control" required>
                                                <option value="" disabled selected>Pilih</option>
                                                <option value="0">Belum Menikah</option>
                                                <option value="1">Menikah</option>
                                                <option value="2">Janda / Duda</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Pekerjaan</label>
                                            <select name="pekerjaan" class="form-control" required>
                                                <option value="">-- Pilih Pekerjaan --</option>
                                                @foreach($pekerjaan as $p)
                                                <option value="{{ $p->nama_pekerjaan }}">{{ $p->nama_pekerjaan }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Pendidikan</label>
                                            <select name="pendidikan" class="form-control" required>
                                                <option value="" disabled selected>-- Pilih pendidikan --</option>
                                                <option value="1">SD</option>
                                                <option value="2">SMP</option>
                                                <option value="3">SMA</option>
                                                <option value="4">D4/S1</option>
                                                <option value="5">S2</option>
                                                <option value="6">S3</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Email (Opsional)</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Alamat Lengkap</label>
                                            <textarea name="alamat_lengkap" class="form-control" rows="2"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>No Telepon</label>
                                            <input type="number" name="kontak_darurat_nama" class="form-control" placeholder="08xxxxxxxxxx" required>
                                        </div>

                                        <div class="form-group">
                                            <label>No Telepone Darurat</label>
                                            <input type="number" name="kontak_darurat_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Paket Keberangkatan</label>
                                            <select name="paket_id" id="paket_id" class="form-control" required>
                                                <option value="" disabled {{ old('paket_id') ? '' : 'selected' }}>-- Pilih Paket --</option>
                                                @foreach($paket as $p)
                                                <option value="{{ $p->id }}" data-nama="{{ $p->nama_paket }}"
                                                    {{ old('paket_id') == $p->id ? 'selected' : '' }}>
                                                    {{ $p->nama_paket }} - Rp {{ number_format($p->harga_paket, 0, ',', '.') }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="tgl_keberangkatan_div" style="display: none;">
                                            <label>Tanggal Keberangkatan</label>
                                            <input type="date" name="tgl_keberangkatan" id="tgl_keberangkatan" class="form-control">
                                        </div>


                                        <script>
                                            const paketSelect = document.getElementById('paket_id');
                                            const tanggalDiv = document.getElementById('tgl_keberangkatan_div');
                                            const tanggalInput = document.getElementById('tgl_keberangkatan');

                                            // array tanggal yang sudah dibooking jamaah lain (format yyyy-mm-dd)
                                            const bookedDates = @json($bookedDates ?? []);

                                            function toggleTanggal() {
                                                const selectedOption = paketSelect.options[paketSelect.selectedIndex];
                                                const namaPaket = selectedOption.dataset.nama;

                                                if (namaPaket === 'Umroh Private') {
                                                    tanggalDiv.style.display = 'block';
                                                    enableDisableDates();
                                                } else {
                                                    tanggalDiv.style.display = 'none';
                                                }
                                            }

                                            function enableDisableDates() {
                                                // gunakan min/max sesuai kebutuhan
                                                const today = new Date().toISOString().split('T')[0];
                                                tanggalInput.setAttribute('min', today);

                                                tanggalInput.addEventListener('input', function() {
                                                    if (bookedDates.includes(this.value)) {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: 'Tanggal ini sudah dibooking jamaah lain, pilih tanggal lain!',
                                                        });
                                                        this.value = '';
                                                    }
                                                });
                                            }

                                            paketSelect.addEventListener('change', toggleTanggal);

                                            // Jalankan saat halaman load agar sesuai data edit
                                            toggleTanggal();
                                        </script>

                                        <hr>
                                        <h4>B. Passport</h4>

                                        <div class="form-group">
                                            <label>Apakah Bapak/Ibu sudah memiliki Passport ? </label>
                                            <select name="status_passport" id="status_passport" class="form-control" required>
                                                <option value="sudah">Sudah</option>
                                                <option value="belum" selected>Belum</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Nomor KTP</label>
                                            <input type="number" name="no_ktp" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Upload Foto KTP</label>
                                            <input type="file" name="foto_ktp" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Upload Foto KK</label>
                                            <input type="file" name="foto_kk" class="form-control">
                                        </div>

                                        <div id="berkas_passport_sudah" style="display:none;">
                                            <div class="form-group">
                                                <label>Upload Foto Passport (halaman 4 bagian data diri)</label>
                                                <input type="file" name="foto_paspor" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label>Nomor Paspor</label>
                                                <input type="number" name="no_paspor" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Terbit</label>
                                                <input type="date" name="tgl_terbit" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Expire</label>
                                                <input type="date" name="tgl_exp" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Daerah Penerbitan</label>
                                                <input type="text" name="daerah_penerbitan" class="form-control">
                                            </div>
                                        </div>

                                        <div id="berkas_passport_belum" style="display:none;">
                                            <div class="form-group">
                                                <label>Akte Kelahiran/Buku Nikah/Ijazah</label>
                                                <input type="file" name="foto_akte" class="form-control">
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
                                        <h4> C. Vaksinasi</h4>

                                        <div class="form-group">
                                            <label>Apakah Bapak/Ibu sudah melakukan Vaksi Meningitis?</label>
                                            <select id="status_vaksin_meningitis" name="status_vaksin_meningitis" class="form-control" required>
                                                <option value="" disabled selected>Pilih</option>
                                                <option value="sudah">Sudah</option>
                                                <option value="belum">Belum</option>
                                            </select>
                                        </div>

                                        <div id="sudah_vaksin" style="display: none;">
                                            <div class="form-group">
                                                <label>Surat Vaksin</label>
                                                <input type="file" name="foto_vaksin" class="form-control">
                                            </div>
                                        </div>


                                        <script>
                                            document.getElementById("status_vaksin_meningitis").addEventListener("change", function() {
                                                const val = this.value;
                                                const sudahVaksin = document.getElementById("sudah_vaksin");

                                                if (val === "sudah") {
                                                    sudahVaksin.style.display = "block";
                                                } else {
                                                    sudahVaksin.style.display = "none";
                                                }
                                            });
                                        </script>

                                        <!-- <hr>
                                        <h4>D. Pembayaran</h4>

                                        <div class="form-group">
                                            <label>Bukti Pembayaran</label>
                                            <input type="file" id="bukti_bayar_dp_input" name="bukti_bayar_dp" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nominal Pembayaran</label>
                                            <input type="text" id="nominal_output" class="form-control">
                                        </div>
                                        <input type="hidden" id="nominal_output2" name="nominal" class="form-control"> -->

                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>

                                </form>
                            </div>

                            <!-- /.card -->
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
</body>

</html>