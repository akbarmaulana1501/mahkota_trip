<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Auth::guard('jamaah')->user()->username ?? Auth::user()->name }} | Mahkota Trip</title>

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

                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <!-- Judul -->
                            <div class="mb-4">
                                <h3 class="font-weight-bold mb-1">
                                    Dokumen Saya
                                </h3>
                                <p class="text-muted">
                                    Pastikan semua dokumen sudah lengkap
                                </p>
                                <hr>
                            </div>

                            <div class="row">

                                <!-- PASPOR -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card border shadow-sm h-100">
                                        <div class="card-body text-center">

                                            <div style="font-size:50px;">🛂</div>

                                            <h5 class="font-weight-bold mt-3">
                                                Paspor
                                            </h5>

                                            <span class="badge badge-success px-3 py-2 mt-2">
                                                Sudah Upload
                                            </span>

                                            <div class="mt-4">
                                                <a href="#" class="btn btn-primary btn-block">
                                                    Lihat Dokumen
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- KTP -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card border shadow-sm h-100">
                                        <div class="card-body text-center">

                                            <div style="font-size:50px;">🪪</div>

                                            <h5 class="font-weight-bold mt-3">
                                                KTP
                                            </h5>

                                            <span class="badge badge-danger px-3 py-2 mt-2">
                                                Belum Upload
                                            </span>

                                            <div class="mt-4">
                                                <a href="#" class="btn btn-success btn-block">
                                                    Upload Sekarang
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- FOTO -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card border shadow-sm h-100">
                                        <div class="card-body text-center">

                                            <div style="font-size:50px;">📷</div>

                                            <h5 class="font-weight-bold mt-3">
                                                Foto 4x6
                                            </h5>

                                            <span class="badge badge-warning px-3 py-2 mt-2">
                                                Menunggu Validasi
                                            </span>

                                            <div class="mt-4">
                                                <a href="#" class="btn btn-primary btn-block">
                                                    Lihat Detail
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
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
    <script>
        document.getElementById('copyBtn').addEventListener('click', function() {
            const link = document.getElementById('qrLink');
            link.select();
            link.setSelectionRange(0, 99999); // Untuk perangkat mobile

            navigator.clipboard.writeText(link.value)
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Link berhasil disalin ke clipboard.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Link gagal disalin.'
                    });
                });
        });
    </script>
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.getElementById('qrModal').addEventListener('shown.bs.modal', function() {

            const referral = document.getElementById('qrReferralCode').value;
            const link = "{{ url('/tambah-jamaah') }}?ref=" + referral;

            document.getElementById('qrLink').value = link;

            const qrContainer = document.getElementById('qrCodeContainer');
            qrContainer.innerHTML = '';

            new QRCode(qrContainer, {
                text: link,
                width: 220,
                height: 220
            });
        });

        document.getElementById('downloadQR').addEventListener('click', function() {
            // QRCode.js membuat <img> atau <canvas>, kita ambil canvas
            const container = document.getElementById('qrCodeContainer');
            const img = container.querySelector('img');

            if (img) {
                // Buat link download
                const a = document.createElement('a');
                a.href = img.src;
                a.download = 'QR_Referral.png';
                a.click();
            } else {
                alert('QR Code belum siap.');
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: "Yakin ingin menghapus?",
                        text: "Data tidak bisa dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-validasi');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const status = parseInt(this.dataset.status); // ambil status_validasi

                    if (status === 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: 'Jamaah telah divalidasi!',
                        });
                        return; // hentikan eksekusi jika sudah valid
                    }

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Status validasi akan diubah menjadi 'Sudah'!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, validasi!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // redirect ke route validasi
                            window.location.href = `/validasi-jamaah/${id}`;
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>