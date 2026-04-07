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
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- Judul Halaman -->
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <h3><b>Jadwal Umroh Saya</b></h3>
                        </div>
                    </div>

                    <!-- Card Informasi Paket -->
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card shadow">
                                <div class="card-body">

                                    <h4 class="text-success text-center mb-4">
                                        <b>Umroh Ramadhan 2026</b>
                                    </h4>

                                    <div style="font-size:18px; line-height:32px;">

                                        <p><b>Tanggal Berangkat :</b> 12 Maret 2026</p>
                                        <p><b>Tanggal Pulang :</b> 21 Maret 2026</p>
                                        <p><b>Durasi :</b> 9 Hari</p>
                                        <p><b>Maskapai :</b> Saudi Airlines</p>
                                        <p><b>Hotel Mekkah :</b> Hotel XYZ</p>
                                        <p><b>Hotel Madinah :</b> Hotel ABC</p>

                                    </div>

                                    <div class="alert alert-success text-center mt-4" style="font-size:18px;">
                                        ✅ Status: Siap Berangkat
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Countdown -->
                    <div class="row mt-4">
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4><b>⏳ 28 Hari Lagi Menuju Keberangkatan</b></h4>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Itinerary -->
                    
                </div>
            </section>
            <!-- /.content -->


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
</body>

</html>