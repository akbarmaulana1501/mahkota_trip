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

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Komentar</h3>

                                </div>
                                @if (session('deleteKomentar'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Komentar Berhasil dihapus!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif

                                @if (session('success_validasi_komentar'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Komentar Berhasil ditampilkan!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Komentar</th>
                                                <th>Status</th>
                                                <th>Rating</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($komentar as $index => $k)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $k->nama }}</td>
                                                <td>{{ $k->email}}</td>
                                                <td>{{ $k->pesan ?? '-' }}</td>
                                                <td class="text-center">
                                                    @if($k->status == 0)
                                                    <span class="badge bg-danger"><i class="fas fa-eye-slash"></i></span>
                                                    @elseif($k->status == 1)
                                                    <span class="badge bg-success"><i class="fas fa-eye"></i></span>
                                                    @endif
                                                </td>
                                                <td>{{ $k->rating }} </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <form action="{{ route('komentar.destroy', $k->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" style="min-width: 120px;">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>

                                                        <button type="button"
                                                            class="btn btn-success btn-sm btn-validasi"
                                                            data-id="{{ $k->id }}"
                                                            data-status="{{ $k->status }}"
                                                            style="min-width: 120px;">
                                                            <i class="fas fa-check"></i> Validasi
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                            text: 'komentar telah ditampilkan!',
                        });
                        return; // hentikan eksekusi jika sudah valid
                    }

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Status validasi akan diubah menjadi 'ditampilkan'!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, validasi!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // redirect ke route validasi
                            window.location.href = `/validasi-komentar/${id}`;
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>