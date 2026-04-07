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
                                    <h3 class="card-title">Data Komisi</h3>

                                </div>

                                @if (session('success_komisi'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Komisi Berhasil diperbarui!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('success_komisi_validasi'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Komisi Berhasil diValidasi!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif


                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama Jamaah</th>
                                                <th class="text-center">Nama Marketing</th>
                                                <th class="text-center">Komisi</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Tanggal Cair</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($komisi as $index => $k)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $k->jamaah->nama_depan }} {{ $k->jamaah->nama_belakang }}</td>
                                                <td>{{ $k->marketing->username}}</td>
                                                <td>Rp {{ number_format($k->nominal_komisi, 0, ',', '.') ?? '-' }}</td>
                                                <td class="text-center">
                                                    @if($k->status == 0)
                                                    <span class="badge bg-danger">Belum</span>
                                                    @elseif($k->status == 1)
                                                    <span class="badge bg-success">Sudah</span>
                                                    @endif
                                                </td>
                                                <td>{{ $k->tgl_cair }} </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button
                                                            class="btn btn-warning btn-sm"
                                                            onclick="openEditKomisi(
                                                                '{{ $k->id }}',
                                                                '{{ $k->jamaah->nama_depan }} {{ $k->jamaah->nama_belakang }}',
                                                                '{{ $k->nominal_komisi }}',
                                                                '{{ $k->status }}',
                                                                '{{ $k->tgl_cair }}'
                                                            )"
                                                            data-toggle="modal"
                                                            data-target="#modalEditKomisi">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>

                                                        @if($k->status == 0)
                                                        <button type="button"
                                                            class="btn btn-success btn-sm btn-validasi"
                                                            data-id="{{ $k->id }}"
                                                            data-status="{{ $k->status }}">
                                                            <i class="fas fa-check"></i> Validasi
                                                        </button>
                                                        @endif

                                                    </div>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="modal fade" id="modalEditKomisi" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('komisi_admin.update') }}" method="POST" onsubmit="return cleanRupiah()">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Komisi</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">

                                                    <!-- Hidden ID -->
                                                    <input type="hidden" name="id" id="edit_id">

                                                    <div class="form-group">
                                                        <label>Nama Jamaah</label>
                                                        <input type="text" id="edit_nama" class="form-control" readonly>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nominal Komisi</label>
                                                        <input type="text" name="nominal_komisi" id="edit_nominal"
                                                            class="form-control" onkeyup="formatRupiah(this)">
                                                    </div>

                                                    <!-- <div class="form-group">
                                                        <label>Status</label>
                                                        <select name="status" id="edit_status" class="form-control">
                                                            <option value="0">Belum</option>
                                                            <option value="1">Sudah</option>
                                                        </select>
                                                    </div> -->

                                                    <div class="form-group">
                                                        <label>Tanggal Cair</label>
                                                        <input type="date" name="tgl_cair" id="edit_tgl_cair" class="form-control">
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                </div>

                                            </form>
                                        </div>
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
        function openEditKomisi(id, nama, nominal, tgl_cair) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_nominal').value = nominal ?? '';
            document.getElementById('edit_tgl_cair').value = tgl_cair ?? '';

            formatRupiah(document.getElementById('edit_nominal'));
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-validasi');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const status = parseInt(this.dataset.status);

                    // Jika sudah divalidasi
                    if (status === 1) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sudah divalidasi',
                            text: 'Komisi ini sudah dicairkan!',
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Komisi akan dicairkan ke marketing!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, validasi!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/validasi-komisi/${id}`;
                        }
                    });
                });
            });
        });
    </script>
    <script>
        function formatRupiah(input) {
            let angka = input.value.replace(/[^,\d]/g, '').toString();
            let split = angka.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            input.value = rupiah ? 'Rp ' + rupiah : '';
        }
    </script>
    <script>
        function cleanRupiah() {
            let input = document.getElementById('edit_nominal');
            input.value = input.value.replace(/[^0-9]/g, '');
            return true;
        }
    </script>
</body>

</html>