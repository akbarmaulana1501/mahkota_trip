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

                @if (session('success_update'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Visa Berhasil diupdate!",
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
                                    <h3 class="card-title">Daftar Visa Jamaah</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama Jamaah</th>
                                                <th class="text-center">No Paspor</th>
                                                <th class="text-center">Tanggal Lahir</th>
                                                <th class="text-center">Paket</th>
                                                <th class="text-center">Status Bayar</th>
                                                <th class="text-center">Status Visa</th>
                                                <th class="text-center">File Visa</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($visa as $i => $v)
                                            <tr>
                                                <td>{{ $i+1 }}</td>

                                                <td>{{ $v->nama_depan . ' ' . $v->nama_belakang  }}</td>

                                                <td>{{ $v->no_pasport }}</td>

                                                <td>{{ date('d-m-Y', strtotime($v->tanggal_lahir)) }}</td>

                                                <td>{{ $v->paket ?? '-' }}</td>

                                                @php
                                                $nama = strtolower($v->nama_depan . ' ' . $v->nama_belakang);

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
                                                    @if($v->status_visa == 0)
                                                    <span class="badge badge-danger">Belum Terbit</span>
                                                    @elseif($v->status_visa == 1)
                                                    <span class="badge badge-success">Sudah Terbit</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if($v->foto_visa)
                                                    <a href="{{ asset('storage/'.$v->foto_visa) }}"
                                                        target="_blank"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @else
                                                    -
                                                    @endif
                                                </td>

                                                <td>
                                                    <button
                                                        class="btn btn-warning btn-sm"
                                                        onclick="openEditVisa(
                                                            '{{ $v->id }}',
                                                            '{{ $v->nama_depan }} {{ $v->nama_belakang }}',
                                                            '{{ $v->status_visa }}',
                                                            '{{ $v->foto_visa }}'
                                                        )"
                                                        data-toggle="modal"
                                                        data-target="#modalEditVisa">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="modal fade" id="modalEditVisa" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('UpdateVisa') }}" enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="id" id="edit_id">

                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Visa Jamaah</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label>Nama Jamaah</label>
                                                        <input type="text" id="edit_nama" class="form-control" readonly>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Status Visa</label>
                                                        <select name="status_visa" id="edit_status" class="form-control" onchange="toggleFotoVisa()">
                                                            <option value="0">Belum</option>
                                                            <option value="1">Selesai</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group" id="group_foto_visa" style="display:none;">
                                                        <label>Upload Foto Visa</label>
                                                        <input type="file" name="foto_visa" class="form-control">
                                                        <small class="text-muted">Format: JPG / PNG / PDF</small>

                                                        <div class="mt-2">
                                                            <a href="#"
                                                                id="lihat_foto_visa"
                                                                target="_blank"
                                                                class="btn btn-info btn-sm"
                                                                style="display:none;">
                                                                <i class="fas fa-eye"></i> Lihat Foto
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>

                                                <script>
                                                    function openEditVisa(id, nama, status, foto) {

                                                        // set data baru
                                                        document.getElementById('edit_id').value = id;
                                                        document.getElementById('edit_nama').value = nama;
                                                        document.getElementById('edit_status').value = status;

                                                        // reset dulu (biar gak nyangkut)
                                                        const group = document.getElementById('group_foto_visa');
                                                        group.style.display = 'none';

                                                        const fileInput = group.querySelector('input[type="file"]');
                                                        if (fileInput) fileInput.value = '';

                                                        const lihatBtn = document.getElementById('lihat_foto_visa');

                                                        // tampilkan sesuai data baru
                                                        if (status == '1') {
                                                            group.style.display = 'block';
                                                        }

                                                        if (foto) {
                                                            lihatBtn.style.display = 'inline-block';
                                                            lihatBtn.href = '/storage/' + foto;
                                                        } else {
                                                            lihatBtn.style.display = 'none';
                                                            lihatBtn.href = '#';
                                                        }
                                                    }
                                                </script>
                                                <script>
                                                    function toggleFotoVisa() {
                                                        const status = document.getElementById('edit_status').value;
                                                        const group = document.getElementById('group_foto_visa');

                                                        if (status == '1') {
                                                            group.style.display = 'block';
                                                        } else {
                                                            group.style.display = 'none';

                                                            // reset file
                                                            const fileInput = group.querySelector('input[type="file"]');
                                                            if (fileInput) fileInput.value = '';
                                                        }
                                                    }
                                                </script>

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
        $(document).on('click', '.btn-edit-visa', function() {

            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let status = $(this).data('status');
            let foto = $(this).data('foto');

            $('#edit_id').val(id);
            $('#edit_nama').val(nama);
            $('#edit_status').val(status);

            if (foto) {
                $('#lihat_foto_visa')
                    .attr('href', '/storage/' + foto)
                    .show();
            } else {
                $('#lihat_foto_visa').hide();
            }

        });
    </script>
</body>

</html>