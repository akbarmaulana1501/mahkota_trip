<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ auth()->user()->username }} | Mahkota Trip</title>

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

                @if (session('success_tiket'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Data tiket berhasil ditambahkan!",
                        showConfirmButton: true,
                    });
                </script>
                @endif

                @if (session('success_update_tiket'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Data tiket berhasil diupdate!",
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
                            <div class="mb-3">
                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTiket">
                                    <i class="fa fa-plus"></i> Tambah Tiket
                                </a>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Tiket Berangkat</h3>

                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Jamaah</th>
                                                <th>Tanggal Keberangkatan</th>
                                                <th>waktu keberangkatan</th>
                                                <th>waktu sampai</th>
                                                <th>maskapai</th>
                                                <th>kode PNR</th>
                                                <th>Bandara</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($berangkat as $index => $b)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $b->jamaah->nama_depan . ' ' . $b->jamaah->nama_belakang }}</td>
                                                <td>{{ $b->tgl_berangkat }}</td>
                                                <td>{{ $b->waktu_berangkat }}</td>
                                                <td>{{ $b->waktu_sampai ?? '-' }}</td>
                                                <td>{{ $b->maskapai ?? '-' }}</td>
                                                <td>{{ $b->kode ?? '-' }}</td>
                                                <td>{{ $b->bandara ?? '-' }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-warning btn-sm btn-edit"
                                                        data-id="{{ $b->id }}"
                                                        data-jenis="Berangkat"
                                                        data-tgl="{{ $b->tgl_berangkat }}"
                                                        data-berangkat="{{ $b->waktu_berangkat }}"
                                                        data-sampai="{{ $b->waktu_sampai }}"
                                                        data-maskapai="{{ $b->maskapai }}"
                                                        data-kode="{{ $b->kode }}"
                                                        data-bandara="{{ $b->bandara }}"
                                                        data-toggle="modal"
                                                        data-target="#modalEdit">
                                                        <i class="fas fa-pen"></i> Edit
                                                    </button>
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
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <!-- /.card -->

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Tiket Pulang</h3>

                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Jamaah</th>
                                                <th>Tanggal Keberangkatan</th>
                                                <th>waktu keberangkatan</th>
                                                <th>waktu sampai</th>
                                                <th>maskapai</th>
                                                <th>kode PNR</th>
                                                <th>Bandara</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pulang as $index => $p)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $b->jamaah->nama_depan . ' ' . $b->jamaah->nama_belakang }}</td>
                                                <td>{{ $p->tgl_berangkat }}</td>
                                                <td>{{ $b->waktu_berangkat }}</td>
                                                <td>{{ $p->waktu_sampai ?? '-' }}</td>
                                                <td>{{ $p->maskapai ?? '-' }}</td>
                                                <td>{{ $p->kode ?? '-' }}</td>
                                                <td>{{ $p->bandara ?? '-' }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-warning btn-sm btn-edit"
                                                        data-id="{{ $p->id }}"
                                                        data-jenis="Pulang"
                                                        data-tgl="{{ $p->tgl_berangkat }}"
                                                        data-berangkat="{{ $p->waktu_berangkat }}"
                                                        data-sampai="{{ $p->waktu_sampai }}"
                                                        data-maskapai="{{ $p->maskapai }}"
                                                        data-kode="{{ $p->kode }}"
                                                        data-bandara="{{ $p->bandara }}"
                                                        data-toggle="modal"
                                                        data-target="#modalEdit">
                                                        <i class="fas fa-pen"></i> Edit
                                                    </button>
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
            <!-- Modal -->
            <div class="modal fade" id="modalTiket" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('tiket.store') }}" method="POST">
                            @csrf
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title">Tambah Tiket Berangkat / Pulang</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>


                            <div class="modal-body">

                                <!-- Jenis Tiket -->
                                <div class="form-group">
                                    <label>Jenis Tiket</label>
                                    <select name="jenis" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Berangkat</option>
                                        <option value="2">Pulang</option>
                                    </select>
                                </div>

                                <!-- Nama Jamaah -->
                                <div class="form-group">
                                    <label>Nama Jamaah</label>
                                    <select name="jamaah_id" class="form-control" required>
                                        <option value="">-- Pilih Jamaah --</option>
                                        @foreach($jamaah as $j)
                                        <option value="{{ $j->id }}">
                                            {{ $j->nama_depan . ' ' . $j->nama_belakang }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tanggal -->
                                <div class="form-group">
                                    <label>Tanggal Keberangkatan</label>
                                    <input type="date" name="tanggal" class="form-control" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Waktu Berangkat</label>
                                        <input type="time" name="waktu_berangkat" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Waktu Sampai</label>
                                        <input type="time" name="waktu_sampai" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Maskapai -->
                                <div class="form-group mt-2">
                                    <label>Maskapai</label>
                                    <input type="text" name="maskapai" class="form-control" required>
                                </div>

                                <!-- PNR -->
                                <div class="form-group">
                                    <label>Kode PNR</label>
                                    <input type="text" name="pnr" class="form-control" required>
                                </div>

                                <!-- Bandara -->
                                <div class="form-group">
                                    <label>Bandara</label>
                                    <input type="text" name="bandara" class="form-control" value="Sultan Syarif Qasim" required>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalEdit" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Edit Tiket</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form method="POST" id="formEdit">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" name="tgl_berangkat" id="tgl" class="form-control">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Waktu Berangkat</label>
                                        <input type="time" name="waktu_berangkat" id="berangkat" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Waktu Sampai</label>
                                        <input type="time" name="waktu_sampai" id="sampai" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <label>Maskapai</label>
                                    <input type="text" name="maskapai" id="maskapai" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Kode PNR</label>
                                    <input type="text" name="kode" id="kode" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Bandara</label>
                                    <input type="text" name="bandara" id="bandara" class="form-control">
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
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
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": ["copy", "csv", "excel", "pdf"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
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
        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let jenis = $(this).data('jenis');

            // ubah action form
            $('#formEdit').attr('action', '/tiket/' + id);

            // ubah judul modal
            $('#modalTitle').text('Edit Tiket ' + jenis);

            // isi form
            $('#tgl').val($(this).data('tgl'));
            $('#berangkat').val($(this).data('berangkat'));
            $('#sampai').val($(this).data('sampai'));
            $('#maskapai').val($(this).data('maskapai'));
            $('#kode').val($(this).data('kode'));
            $('#bandara').val($(this).data('bandara'));
        });
    </script>
</body>

</html>