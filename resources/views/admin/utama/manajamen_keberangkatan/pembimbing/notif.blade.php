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
                                    <h3 class="card-title">Kirim Notifikasi</h3>
                                </div>

                                <form action="{{ route('Notifikasi') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nama Jamaah</label>
                                            <input type="text" name="nama_jamaah" value="{{$jamaah->nama_lengkap}}" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>No Telepon</label>
                                            <input type="text" name="no_telepon" value="{{$jamaah->kontak_darurat_hp}}" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Paket</label>
                                            <input type="text" name="paket" class="form-control" value="{{$jamaah->nama_paket}}" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Tanggal Keberangkatan</label>
                                            <input type="text" name="tgl_berangkat" value="{{$jamaah->tgl_berangkat}}" class="form-control" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Pesan</label>
                                            <textarea name="pesan" class="form-control" rows="8">Assalamu’alaikum Warahmatullahi Wabarakatuh
Yth. Bapak/Ibu {{$jamaah->nama_lengkap}},

Dengan hormat, kami informasikan bahwa pembayaran Anda telah dinyatakan LUNAS dan seluruh data keberangkatan telah berhasil divalidasi oleh pihak administrasi.

Alhamdulillah, saat ini Bapak/Ibu telah resmi terdaftar sebagai calon jemaah keberangkatan tanggal {{$jamaah->tgl_berangkat}} .

Selanjutnya:
Silakan menunggu informasi berikutnya terkait jadwal manasik, pembagian perlengkapan, dan keberangkatan. Informasi akan disampaikan melalui grup resmi dan pesan pribadi.

Jika ada pertanyaan lebih lanjut, silakan menghubungi kami melalui layanan admin.

Terima kasih atas kepercayaan Bapak/Ibu.
Semoga Allah memudahkan segala urusan Bapak/Ibu dan memberikan keberkahan untuk perjalanan ibadah ini. 🤲

Wassalamu’alaikum Warahmatullahi Wabarakatuh
Manajemen, 
Mahkota Trip</textarea>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Kirim</button>
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