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
                                    <h3 class="card-title">Daftar Logistik</h3>

                                </div>

                                @if (session('success_logistik'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Logistik Berhasil ditambah!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('success_update_logistik'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Logistik Berhasil diperbarui!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('success_hapus_logistik'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Logistik Berhasil dihapus!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="{{route('logistik.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Logistik</a>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label>Dari Tanggal</label>
                                            <input type="date" id="minDate" class="form-control">
                                        </div>

                                        <div class="col-md-3">
                                            <label>Sampai Tanggal</label>
                                            <input type="date" id="maxDate" class="form-control">
                                        </div>

                                        <div class="col-md-3 d-flex align-items-end">
                                            <button class="btn btn-secondary" id="resetFilter">
                                                Reset Filter
                                            </button>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama Barang</th>
                                                <th class="text-center">Jumlah</th>
                                                <th class="text-center">Sisa Stok</th>
                                                <th class="text-center">Tanggal Pengadaan</th>
                                                <th class="text-center">Bukti Pengadaan</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($logistik as $no => $l)
                                            <tr>
                                                <td class="text-center">{{ $no + 1 }}</td>
                                                <td class="text-center">{{ $l->nama_barang }}</td>
                                                <td class="text-center">{{ $l->jumlah }}</td>

                                                {{-- Sisa stok (contoh: sama dengan stok) --}}
                                                <td class="text-center">{{ $l->jumlah }}</td>

                                                {{-- Pakai created_at --}}
                                                <td class="text-center">{{ $l->created_at ? $l->created_at->format('Y-m-d') : '-' }}</td>

                                                <td class="text-center">
                                                    @if ($l->bukti_penyerahan)
                                                    <a href="{{ asset('storage/' . $l->bukti_penyerahan) }}" target="_blank"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                    @else
                                                    <span class="badge badge-secondary">Tidak ada</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    <span class="badge badge-success">Tersedia</span>
                                                </td>

                                                <td class="text-center">
                                                    <a href="{{ route('logistik.edit', $l->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    <form action="{{ route('logistik.delete', $l->id) }}" method="POST" class="delete-form d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
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
        $(document).ready(function() {
            var table = $('#example1').DataTable();

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $('#minDate').val();
                    var max = $('#maxDate').val();
                    var date = data[4]; // index kolom "Tanggal Mendaftar"

                    if (date === '-') return true;

                    if (
                        (min === "" && max === "") ||
                        (min === "" && date <= max) ||
                        (max === "" && date >= min) ||
                        (date >= min && date <= max)
                    ) {
                        return true;
                    }
                    return false;
                }
            );

            $('#minDate, #maxDate').on('change', function() {
                table.draw();
            });

            $('#resetFilter').on('click', function() {
                $('#minDate').val('');
                $('#maxDate').val('');
                table.draw();
            });
        });
    </script>
</body>

</html>