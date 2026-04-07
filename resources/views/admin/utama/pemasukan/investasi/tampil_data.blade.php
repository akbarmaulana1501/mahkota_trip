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

                @if (session('success_pengeluaran'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Pengeluaran Berhasil direquest!",
                        showConfirmButton: true,
                    });
                </script>
                @endif

                @if (session('success_update_pengeluaran'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Pengeluaran Berhasil diupdate!",
                        showConfirmButton: true,
                    });
                </script>
                @endif

                @if (session('success_delete_pengeluaran'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Pengeluaran Berhasil dihapus!",
                        showConfirmButton: true,
                    });
                </script>
                @endif

                @if (session('success_verified'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Pengeluaran Berhasil diverifikasi!",
                        showConfirmButton: true,
                    });
                </script>
                @endif

                @if (session('error_verified'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Kesalahan!",
                        text: "Pengeluaran sudah diverifikasi!",
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
                                    <h3 class="card-title">Daftar Investasi</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="#" class="btn btn-sm btn-primary"
                                            data-toggle="modal"
                                            data-target="#modalInvestasi"
                                            onclick="openCreateModal()">
                                            <i class="fa fa-plus"></i> Tambah Investasi
                                        </a>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               <th>No</th>
                                               <th>Nama Jamaah</th>
                                               <th>Tanggal</th>
                                               <th>Jumlah Investasi</th>
                                               <th>Keterangan</th> 
                                               <th>Dibuat</th> 
                                               <th>Aksi</th> 
                                            </tr>
                                        </thead>
                                        
                                    </table>
                                </div>

                                <div class="modal fade" id="modalPengeluaran">
                                    <div class="modal-dialog modal-lg">
                                        <form id="formPengeluaran" method="POST">
                                            @csrf
                                            <input type="hidden" id="methodField" name="_method">
                                            <input type="hidden" id="pengeluaran_id">

                                            <div class="modal-content">

                                                <div class="modal-header bg-primary">
                                                    <h4 class="modal-title" id="modalTitle">Tambah Pengeluaran</h4>
                                                    <button type="button" class="close text-white" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <label>Item</label>
                                                            <input type="text" id="item" name="item" class="form-control" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Kuantiti</label>
                                                            <input type="number" id="kuantiti" name="kuantiti" class="form-control" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Satuan</label>
                                                            <input type="text" id="satuan" name="satuan" class="form-control">
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label>Harga Satuan</label>
                                                            <input type="number" id="harga_satuan" name="harga_satuan" class="form-control" required>
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label>Total Harga</label>
                                                            <input type="text" id="total_harga_view" class="form-control" readonly>
                                                            <input type="hidden" id="total_harga" name="total_harga">
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">
                                                        Simpan
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        Tutup
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
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        function hitungTotal() {
            let qty = document.getElementById('kuantiti').value;
            let harga = document.getElementById('harga_satuan').value;

            qty = qty ? parseFloat(qty) : 0;
            harga = harga ? parseFloat(harga) : 0;

            let total = qty * harga;

            document.getElementById('total_harga').value = total;
            document.getElementById('total_harga_view').value = formatRupiah(total);
        }

        document.getElementById('kuantiti').addEventListener('input', hitungTotal);
        document.getElementById('harga_satuan').addEventListener('input', hitungTotal);
    </script>

    <script>
        function openCreateModal() {

            document.getElementById('modalTitle').innerText = "Tambah Pengeluaran";

            document.getElementById('formPengeluaran').action = "{{ route('pengeluaran.store') }}";

            document.getElementById('methodField').value = "";

            document.getElementById('item').value = "";
            document.getElementById('kuantiti').value = "";
            document.getElementById('satuan').value = "";
            document.getElementById('harga_satuan').value = "";
            document.getElementById('total_harga').value = "";
        }

        function openEditModal(id, item, kuantiti, satuan, harga) {

            document.getElementById('modalTitle').innerText = "Edit Pengeluaran";

            document.getElementById('formPengeluaran').action = "/pengeluaran/" + id;

            document.getElementById('methodField').value = "PUT";

            document.getElementById('item').value = item;
            document.getElementById('kuantiti').value = kuantiti;
            document.getElementById('satuan').value = satuan;
            document.getElementById('harga_satuan').value = harga;

            hitungTotal();
        }
    </script>
    <script>
        document.querySelectorAll('.verifikasi-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Verifikasi Pengeluaran?',
                    text: "Pastikan data sudah benar",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Verifikasi!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
</body>

</html>