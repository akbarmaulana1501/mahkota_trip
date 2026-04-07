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
                                    <h3 class="card-title">Daftar Distribusi Logistik</h3>

                                </div>

                                @if (session('success_serahkan'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Logistik Diserahkan!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif

                                <!-- /.card-header -->
                                <div class="card-body">
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
                                                <th class="text-center">Nama Jamaah</th>
                                                <th class="text-center">Barang Logistik</th>
                                                <th class="text-center">Tanggal Penyerahan</th>
                                                <th class="text-center">Bukti Penyerahan</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jamaah_logistik as $index => $jl)
                                            <tr>

                                                <td class="text-center">{{ $index + 1 }}</td>

                                                <td>
                                                    {{ $jl->nama_depan }} {{ $jl->nama_belakang }}
                                                </td>

                                                <!-- Barang Logistik -->
                                                <td class="text-center">

                                                    @if($jl->penyerahan->count() > 0)

                                                    @foreach($jl->penyerahan as $p)

                                                    @foreach($p->distribusiLogistik as $dl)

                                                    <span class="badge badge-info">
                                                        {{ $dl->logistik->nama_barang }}
                                                    </span>

                                                    @endforeach

                                                    @endforeach

                                                    @else
                                                    -
                                                    @endif

                                                </td>

                                                <!-- Tanggal Penyerahan -->
                                                <td class="text-center">
                                                    {{ optional($jl->penyerahan->first())->tanggal_penyerahan ?? '-' }}
                                                </td>

                                                <!-- Bukti -->
                                                <td class="text-center">

                                                    @php
                                                    $penyerahan = $jl->penyerahan->first();
                                                    @endphp

                                                    @if($penyerahan && $penyerahan->bukti_penyerahan)

                                                    <a href="{{ asset('storage/'.$penyerahan->bukti_penyerahan) }}"
                                                        target="_blank"
                                                        class="btn btn-info btn-sm">

                                                        <i class="fas fa-eye"></i>

                                                    </a>

                                                    @else
                                                    -
                                                    @endif

                                                </td>

                                                <!-- Status -->
                                                @php
                                                $penyerahan = $jl->penyerahan->first();
                                                @endphp
                                                <td class="text-center">
                                                    <span class="badge {{ $penyerahan && $penyerahan->status ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $penyerahan && $penyerahan->status ? 'Sudah' : 'Belum' }}
                                                    </span>
                                                </td>

                                                <!-- Aksi -->
                                                <td class="text-center">

                                                    <a href="#"
                                                        class="btn btn-success btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modalDistribusi"
                                                        onclick="setJamaah('{{ $jl->id }}')">

                                                        <i class="fas fa-hand-holding"></i> Serahkan

                                                    </a>

                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                                <div class="modal fade" id="modalDistribusi" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="{{ route('logistik.serahkan') }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Serahkan Logistik</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    <input type="hidden" name="jamaah_id" id="jamaah_id">

                                                    <!-- Checkbox pilih semua -->
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                                        <label class="form-check-label" for="checkAll">
                                                            Pilih Semua Barang
                                                        </label>
                                                    </div>

                                                    <!-- List Barang -->
                                                    <div class="form-group">
                                                        <label>Barang Logistik</label>

                                                        <div id="listBarang">

                                                            @foreach($logistik as $l)
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input barang-checkbox"
                                                                    name="barang[]"
                                                                    value="{{ $l->id }}"
                                                                    id="barang{{ $l->id }}">

                                                                <label class="form-check-label" for="barang{{ $l->id }}">
                                                                    {{ $l->nama_barang }}
                                                                </label>
                                                            </div>
                                                            @endforeach

                                                        </div>
                                                    </div>

                                                    <!-- Upload Bukti -->
                                                    <div class="form-group">
                                                        <label>Bukti Penyerahan</label>
                                                        <input type="file" name="bukti_penyerahan" class="form-control">
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">
                                                        Simpan
                                                    </button>

                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        Batal
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

    <script>
        function setJamaah(id) {
            document.getElementById('jamaah_id').value = id;
        }
    </script>

    <script>
        document.getElementById('checkAll').addEventListener('change', function() {

            let checkboxes = document.querySelectorAll('.barang-checkbox');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = document.getElementById('checkAll').checked;
            });

        });
    </script>
</body>

</html>