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
                        <div class="col-12">

                            <!-- /.card -->
                            @if (session('successUpdate'))
                            <script>
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Success!",
                                    text: "User Berhasil diperbarui!",
                                    showConfirmButton: true,
                                });
                            </script>
                            @endif
                            @if (session('success'))
                            <script>
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Success!",
                                    text: "User Berhasil ditambah!",
                                    showConfirmButton: true,
                                });
                            </script>
                            @endif
                            @if (session('deleteSuccess'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'User Berhasil dihapus!',
                                });
                            </script>
                            @endif

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Pengguna</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="{{route('user.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-user-plus"></i> Tambah Pengguna</a>
                                    </div>
                                    <div id="roleFilterContainer">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Email</th>
                                                    <th>Nomor HP</th>
                                                    <th>Alamat</th>
                                                    <th>Kantor</th>
                                                    <th>Role</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user as $index => $u)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $u->username }}</td>
                                                    <td>{{ $u->email }}</td>
                                                    <td>{{ $u->no_hp ?? '-' }}</td>
                                                    <td>{{ $u->alamat ?? '-' }}</td>
                                                    <td>{{ $u->kacab ?? '-' }}</td>
                                                    <td>{{ $u->role ?? '-' }}</td>
                                                    <td class="text-center">
                                                        <!-- Tombol Edit -->
                                                        <a href="{{ route('user.edit', $u->id) }}" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        <!-- Tombol Hapus -->
                                                        <form action="{{ route('user.delete', $u->id) }}" method="POST"
                                                            class="delete-form d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->
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
        $(document).ready(function() {

            var table = $("#example1").DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: ["copy", "csv", "excel", "pdf"],
                dom: '<"row align-items-center"<"col-md-4"B><"col-md-4 text-center"r><"col-md-4"f>>rtip'
            });

            table.buttons().container().appendTo('#example1_wrapper .col-md-4:eq(0)');

            // Tambahkan dropdown di tengah
            var roleFilter = `
                <div class="d-flex align-items-center justify-content-center">
                    <label style="margin-right:8px; margin-bottom:0;">Filter Role:</label>
                    <form method="GET" action="{{ route('user.index') }}">
                        <select name="role" 
                                class="form-control form-control-sm"
                                onchange="this.form.submit()" 
                                style="width:180px;">
                            <option value="">-- Semua Role --</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="jamaah" {{ request('role') == 'jamaah' ? 'selected' : '' }}>Jamaah</option>
                        </select>
                    </form>
                </div>
            `;

            // Taruh di tengah row
            $('#example1_wrapper .row:first .col-md-4:eq(1)').html(roleFilter);

        });
    </script>
    <script>
        // saat tombol delete diklik
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // stop submit default

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
    </script>
</body>

</html>