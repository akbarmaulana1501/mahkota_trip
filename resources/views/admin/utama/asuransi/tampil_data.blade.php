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

                @if (session('success_update_asuransi'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Asuransi Berhasil diupdate!",
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
                                    <h3 class="card-title">Daftar Asuransi Jamaah</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Kode Rombongan</th>
                                                <th class="text-center">Nama Rombongan</th>
                                                <th class="text-center">Tanggal Keberangkatan</th>
                                                <th class="text-center">Status Bayar</th>
                                                <th class="text-center">Status Asuransi</th>
                                                <th class="text-center">File Asuransi</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($asuransi as $i => $a)
                                            <tr>
                                                <td>{{ $i+1 }}</td>

                                                <td>{{ $a->kode_rombongan }}</td>

                                                <td>{{ $a->nama_rombongan }}</td>

                                                <td class="text-center">
                                                    {{ $a->tgl_keberangkatan }}
                                                </td>

                                                @php
                                                $nama = strtolower($a->nama_rombongan);

                                                $bayar = \App\Models\Pengeluaran::where('item', 'like', '%'.$nama.'%')
                                                ->whereNotNull('validation_by') // sudah divalidasi superadmin
                                                ->exists();
                                                @endphp

                                                <td class="text-center">
                                                    @if($bayar)
                                                    <span class="badge badge-success">Sudah</span>
                                                    @else
                                                    <span class="badge badge-danger">Belum</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if($a->status_asuransi == 1)
                                                    <span class="badge bg-success">Sudah Terbit</span>
                                                    @elseif($a->status_asuransi == 0)
                                                    <span class="badge bg-danger">Belum Terbit</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if($a->foto_asuransi)
                                                    <a href="{{ asset('storage/'.$a->foto_asuransi) }}"
                                                        target="_blank"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @else
                                                    -
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="#"
                                                        class="btn btn-warning btn-sm mb-2 btn-edit-asuransi"
                                                        data-id="{{ $a->id }}"
                                                        data-nama="{{ $a->nama_rombongan }}"
                                                        data-tanggal="{{ $a->tgl_keberangkatan }}"
                                                        data-status="{{ $a->status_asuransi }}"
                                                        data-file="{{ $a->foto_asuransi }}"
                                                        data-toggle="modal"
                                                        data-target="#modalEditAsuransi">

                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="modal fade" id="modalEditAsuransi" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="{{ route('UpdateAsuransi') }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="id" id="edit_id">

                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Data Asuransi</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label>Nama Rombongan</label>
                                                        <input type="text" id="edit_nama" class="form-control" readonly>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Tanggal Keberangkatan</label>
                                                        <input type="text" id="edit_tanggal" class="form-control" readonly>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Status Asuransi</label>
                                                        <select name="status_asuransi" id="edit_status" class="form-control" onchange="toggleAsuransi()">
                                                            <option value="0">Belum</option>
                                                            <option value="1">Sudah</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group" id="group_file_asuransi">
                                                        <label>Upload File Asuransi</label>
                                                        <input type="file" name="file_asuransi" class="form-control">
                                                        <small class="text-muted">Format: JPG / PNG / PDF</small>

                                                        <div class="mt-2">
                                                            <a href="#" id="lihat_file_asuransi"
                                                                target="_blank"
                                                                class="btn btn-info btn-sm"
                                                                style="display:none;">
                                                                <i class="fas fa-eye"></i> Lihat File
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">
                                                        Simpan
                                                    </button>
                                                </div>

                                            </div>

                                        </form>
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
        $(document).on('click', '.btn-edit-asuransi', function() {

            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let tanggal = $(this).data('tanggal');
            let status = $(this).data('status');
            let file = $(this).data('file');

            $('#edit_id').val(id);
            $('#edit_nama').val(nama);
            $('#edit_tanggal').val(tanggal);
            $('#edit_status').val(status);

            // 🔥 WAJIB: toggle upload file
            if (status == '1') {
                $('#group_file_asuransi').show();
            } else {
                $('#group_file_asuransi').hide();

                // reset file input
                $('#group_file_asuransi input[type="file"]').val('');
            }

            // tombol lihat file
            if (file) {
                $('#lihat_file_asuransi')
                    .attr('href', '/storage/' + file)
                    .show();
            } else {
                $('#lihat_file_asuransi').hide();
            }

        });
    </script>
    <script>
        function toggleAsuransi() {
            const status = document.getElementById('edit_status').value;

            if (status == '1') {
                $('#group_file_asuransi').show();
            } else {
                $('#group_file_asuransi').hide();
                $('#group_file_asuransi input[type="file"]').val('');
            }
        }
    </script>
</body>

</html>