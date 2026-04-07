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
                                    <h3 class="card-title">Daftar Pembimbing</h3>

                                </div>

                                @if (session('success_hapus_pembimbing'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Pembimbing Berhasil Dihapus!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('error_pembimbing'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: "Kesalahan!",
                                        text: "Tidak dapat menghapus pembimbing karena masih terhubung dengan rombongan!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('success_pembimbing'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Pembimbing Berhasil ditambahkan!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('success_kirim_pesan'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Pesan Berhasil dikirim!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('error_kirim_pesan'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: "Gagal!",
                                        text: "Pesan Gagal dikirim!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('success_update_pembimbing'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Pembimbing Berhasil Diupdate!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <button type="button" class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahPembimbingModal">
                                        <i class="fas fa-user-plus"></i> Tambah Pembimbing
                                    </button>
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
                                                <th class="text-center">Nama Lengkap</th>
                                                <th class="text-center">No Telepon</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Alamat</th>
                                                <th class="text-center">Tanggal Input</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pembimbing as $index => $p)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $p->nama_lengkap }}</td>
                                                <td>{{ $p->no_hp }}</td>
                                                <td>{{ $p->email }}</td>
                                                <td>{{ $p->alamat }}</td>
                                                <td class="text-center">{{ $p->created_at->format('Y-m-d') }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-warning btn-sm btnEditPembimbing"
                                                        data-id="{{ $p->id }}"
                                                        data-nama="{{ $p->nama_lengkap }}"
                                                        data-nohp="{{ $p->no_hp }}"
                                                        data-email="{{ $p->email }}"
                                                        data-alamat="{{ $p->alamat }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#tambahPembimbingModal">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form action="{{ route('pembimbing.delete', $p->id) }}" method="POST" class="delete-form d-inline">
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

                                <div class="modal fade" id="tambahPembimbingModal" tabindex="-1" aria-labelledby="tambahPembimbingModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form id="formPembimbing" method="POST">
                                            @csrf
                                            <input type="hidden" name="pembimbing_id" id="pembimbing_id">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tambahPembimbingModalLabel">Tambah Pembimbing</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="no_hp" class="form-label">No Telepon</label>
                                                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alamat" class="form-label">Alamat</label>
                                                        <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
        const tambahModal = document.getElementById('tambahPembimbingModal');

        tambahModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id'); // jika null berarti tambah

            // elemen form
            const form = document.getElementById('formPembimbing');
            const title = document.getElementById('tambahPembimbingModalLabel');

            // inputan
            document.getElementById('nama_lengkap').value = button.getAttribute('data-nama') || "";
            document.getElementById('no_hp').value = button.getAttribute('data-nohp') || "";
            document.getElementById('email').value = button.getAttribute('data-email') || "";
            document.getElementById('alamat').value = button.getAttribute('data-alamat') || "";

            // mode edit atau tambah
            if (id) {
                // Edit
                title.textContent = "Edit Pembimbing";
                form.action = "{{ route('pembimbing.update') }}";

                // method override PUT
                form.insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT" />');

                document.getElementById('pembimbing_id').value = id;
            } else {
                // Tambah (reset)
                title.textContent = "Tambah Pembimbing";
                form.action = "{{ route('pembimbing.store') }}";

                // hapus method PUT jika sebelumnya edit
                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                document.getElementById('pembimbing_id').value = "";
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example1').DataTable();

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $('#minDate').val();
                    var max = $('#maxDate').val();
                    var date = data[5]; // index kolom "Tanggal Mendaftar"

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