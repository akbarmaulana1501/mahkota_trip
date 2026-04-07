<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Auth::guard('jamaah')->user()->username ?? Auth::user()->name }} | Mahkota Trip</title>

    <!-- Google Font: Source Sans Pro -->
    @include('layouts.style')
</head>
<style>
    .menu-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .menu-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

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
                <!-- Sidebar user panel (optional) -->
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

                <!-- Sidebar Menu -->
                @include('layouts.sidebar')
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        @include('layouts.modals_user')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid py-4">

                    <!-- Header Dashboard -->
                    <div class="mb-4">
                        <h2 class="font-weight-bold mb-1">
                            Dashboard Jamaah
                        </h2>
                        <p class="text-muted">
                            Informasi perjalanan dan layanan umrah Anda
                        </p>
                        <hr>
                    </div>

                    <!-- Kartu Salam -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">

                            <div class="row text-lg">

                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded">
                                        🗓 <strong>Keberangkatan</strong><br>

                                        @if($jamaah->paket=="Umroh Private")
                                        <span class="text-dark">
                                            {{ $jamaah->tgl_keberangkatan ?? '-' }}
                                        </span>
                                        @else
                                        <span class="text-dark">
                                            {{ $jamaah?->paket?->tgl_berangkat ?? '-' }}
                                        </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="col-md-4 ">
                                    <div class="p-3 bg-light rounded">
                                        🛂 <strong>Status Paspor</strong><br>

                                        @if($jamaah->status_passport == "sudah")
                                        <span class="badge badge-success px-3 py-2">
                                            Sudah Terbit
                                        </span>
                                        @else
                                        <span class="badge badge-danger px-3 py-2">
                                            Belum Terbit
                                        </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="col-md-4 ">
                                    <div class="p-3 bg-light rounded">
                                        💳 <strong>Sisa Tagihan</strong><br>
                                        <span class="text-danger font-weight-bold">
                                            Rp {{ number_format(($jamaah->pakets?->harga_paket ?? 0) - ($paid_total ?? 0), 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- Menu Utama -->
                    <div class="row">

                        <!-- Tagihan -->
                        <div class="col-md-6 col-lg-6 mb-4 ">
                            <a href="{{route('tagihanJamaah')}}" class="text-decoration-none menu-card">
                                <div class="card text-center shadow-sm h-100 menu-card">
                                    <div class="card-body py-4">
                                        <div class="mb-3" style="font-size:45px;">💳</div>
                                        <h5 class="font-weight-bold mb-0">
                                            Tabungan Saya
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Dokumen -->
                        <div class="col-md-6 col-lg-6 mb-4 ">
                            <a href="{{route('dokumenJamaah')}}" class="text-decoration-none menu-card">
                                <div class="card text-center shadow-sm h-100 menu-card">
                                    <div class="card-body py-4">
                                        <div class="mb-3" style="font-size:45px;">📄</div>
                                        <h5 class="font-weight-bold mb-0">
                                            Dokumen Saya
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Jadwal -->
                        <!-- <div class="col-md-6 col-lg-4 mb-4">
                            <a href="#" class="text-decoration-none">
                                <div class="card text-center shadow-sm h-100 menu-card">
                                    <div class="card-body py-4">
                                        <div class="mb-3" style="font-size:45px;">✈️</div>
                                        <h5 class="font-weight-bold mb-0">
                                            Jadwal Umrah
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div> -->

                        <!-- Hubungi Admin -->

                    </div>

                </div>
            </div>
        </div>



        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    @include('layouts.script')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
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
</body>

</html>