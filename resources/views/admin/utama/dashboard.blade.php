<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ auth()->user()->username }} | Amanah Travel</title>

  <!-- Google Font: Source Sans Pro -->
  @include('layouts.style')
</head>

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
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
              <p>Tanggal & waktu : <span id="datetime"></span></p>

              <script>
                function updateDateTime() {
                  const now = new Date();

                  const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                  };

                  const tanggal = now.toLocaleDateString('id-ID', options);
                  const jam = now.toLocaleTimeString('id-ID');

                  document.getElementById('datetime').innerHTML = tanggal + ' | ' + jam;
                }

                setInterval(updateDateTime, 1000);
                updateDateTime();
              </script>
            </div><!-- /.col -->
            <div class="col-sm-6">

            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $jamaah }}</h3>
                <p>Total Jamaah Sudah Mendaftar</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
              <a href="{{route('jamaah.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">

                <h3><i class="fas fa-plane"></i> {{$jamaah_berangkat}}</h3>
                <p>Total Jamaah Berangkat Bulan Ini</p>

                <hr style="border-color:white;">

                <h4><i class="fas fa-users"></i> {{$total_rombongan}}</h4>
                <p>Total Rombongan</p>

              </div>

              <a href="{{route('keberangkatan.index')}}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><i class="fas fa-plane"></i> {{$jamaah_sudah_berangkat}}</h3>
                <p>Total Jamaah yang Sudah Berangkat</p>

                <hr style="border-color:white;">

                <h4><i class="fas fa-users"></i> {{$total_rombongan_sudah_berangkat}}</h4>
                <p>Total Rombongan</p>

              </div>

              <a href="" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">

                <h3><i class="fas fa-plane"></i>{{$jamaah_belum_berangkat}} </h3>
                <p>Total Jamaah yang Belum Berangkat</p>

                <hr style="border-color:white;">

                <h4><i class="fas fa-users"></i> {{$total_rombongan_belum_berangkat}}</h4>
                <p>Total Rombongan</p>

              </div>

              <a href="" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$jamaah_belum_validasi}}</h3>
                <p>Jamaah Belum Validasi</p>
              </div>
              <div class="icon">
                <i class="fas fa-check"></i>
              </div>
              <a href="{{ route('jamaah.index', ['filter' => 'belum']) }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$rombongan}}</h3>
                <p>Total Rombongan</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          <div class="col-lg-3 col-6">
            <!-- small box -->

            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$jamaah_belum_logistik}}</h3>
                <p>Pembagian Logistik Belum Selesai</p>
              </div>
              <div class="icon">
                <i class="fas fa-box"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
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