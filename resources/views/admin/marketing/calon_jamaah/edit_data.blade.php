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
                                    <h3 class="card-title">Edit Calon Jamaah</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="{{ route('calonjamaah.update',$calon_jamaah->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="nama_jamaah">Nama Lengkap</label>
                                            <input type="text"
                                                class="form-control @error('nama_jamaah') is-invalid @enderror"
                                                id="nama_jamaah"
                                                name="nama_jamaah"
                                                value="{{ old('nama_jamaah',$calon_jamaah->nama_jamaah) }}"
                                                placeholder="Masukan nama">

                                            @error('nama_jamaah')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                                id="jenis_kelamin" name="jenis_kelamin">

                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L" {{ old('jenis_kelamin',$calon_jamaah->jenis_kelamin)=='L'?'selected':'' }}>Laki-Laki</option>
                                                <option value="P" {{ old('jenis_kelamin',$calon_jamaah->jenis_kelamin)=='P'?'selected':'' }}>Perempuan</option>

                                            </select>

                                            @error('jenis_kelamin')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="no_hp">Nomor Handphone</label>
                                            <input type="number"
                                                class="form-control @error('no_hp') is-invalid @enderror"
                                                id="no_hp"
                                                name="no_hp"
                                                value="{{ old('no_hp',$calon_jamaah->no_hp) }}"
                                                placeholder="contoh:0888xxxxxxxx">

                                            @error('no_hp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="email"
                                                name="email"
                                                value="{{ old('email',$calon_jamaah->email) }}"
                                                placeholder="masukan email">

                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="alamat_lengkap">Alamat Lengkap</label>
                                            <input type="text"
                                                class="form-control @error('alamat_lengkap') is-invalid @enderror"
                                                id="alamat_lengkap"
                                                name="alamat_lengkap"
                                                value="{{ old('alamat_lengkap',$calon_jamaah->alamat_lengkap) }}"
                                                placeholder="contoh: Jl Ahmad Yani">

                                            @error('alamat_lengkap')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="paket_id">Paket Keberangkatan</label>
                                            <select class="form-control @error('paket_id') is-invalid @enderror"
                                                id="paket_id" name="paket_id">

                                                <option value="">Pilih Paket</option>
                                                @foreach($paket as $p)
                                                <option value="{{$p->id}}"
                                                    {{ old('paket_id',$calon_jamaah->paket_diminati) == $p->id ? 'selected' : '' }}>
                                                    {{$p->nama_paket}} - {{$p->harga_paket}}
                                                </option>
                                                @endforeach

                                            </select>

                                            @error('paket_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="kode_referral">Kode Referral</label>
                                            <input type="text"
                                                class="form-control"
                                                id="kode_referral"
                                                name="kode_referral"
                                                value="{{$calon_jamaah->referral_code}}"
                                                readonly>
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
</body>

</html>