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
                                    <h3 class="card-title">Daftar Calon Jamaah</h3>

                                </div>

                                @if (session('success_update'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Jamaah Berhasil diperbarui!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('success_validasi'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Jamaah Berhasil diValidasi!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif


                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#qrModal">
                                            <i class="fa fa-user-plus"></i> Tambah Jamaah
                                        </button>
                                    </div>

                                    <div class="modal fade" id="qrModal" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Link & QR Referral</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body text-center">

                                                    <div class="mb-3">
                                                        <label for="qrLink" class="form-label">Link Pendaftaran</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="qrLink" readonly>
                                                            <button class="btn btn-primary" type="button" id="copyBtn">Copy</button>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Kode Referral</label>
                                                        <input type="hidden"
                                                            class="form-control"
                                                            id="qrReferralCode"
                                                            value="{{ auth()->user()->referral_code }}"
                                                            readonly>
                                                    </div>

                                                    <div id="qrCodeContainer" class="mt-3 d-flex justify-content-center"></div>

                                                    <button id="downloadQR" class="btn btn-success mt-3">
                                                        Download QR
                                                    </button>

                                                </div>


                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Tutup
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama Lengkap</th>
                                                <th class="text-center">No Hp</th>
                                                <th class="text-center">Email</th>
                                                <!-- <th>Kebangsaan</th> -->
                                                <th class="text-center">Paket</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($calon_jamaah as $index => $c)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $c->nama_jamaah }}</td>
                                                <td>{{ $c->no_hp }}</td>
                                                <td>{{ $c->email }}</td>
                                                <td>{{ $c->paket->nama_paket ?? '-' }}</td>
                                                <td>
                                                    @if ($c->status == 0)
                                                    <span class="badge bg-warning text-dark">
                                                        Calon Jamaah
                                                    </span>
                                                    @elseif ($c->status == 1)
                                                    <span class="badge bg-success">
                                                        Jamaah Haji Fix
                                                    </span>
                                                    @endif
                                                </td>
                                                <td>{{ $c->created_at ?? '-' }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('calonjamaah.edit', $c->id) }}" class="btn btn-warning btn-sm mb-2" style="min-width: 120px;">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <button class="btn btn-success btn-sm mb-2 btn-validasi"
                                                        data-id="{{ $c->id }}"
                                                        style="min-width: 120px;">
                                                        <i class="fas fa-check"></i> Validasi
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
        document.getElementById('copyBtn').addEventListener('click', function() {
            const link = document.getElementById('qrLink');
            link.select();
            link.setSelectionRange(0, 99999); // Untuk perangkat mobile

            navigator.clipboard.writeText(link.value)
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Link berhasil disalin ke clipboard.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Link gagal disalin.'
                    });
                });
        });
    </script>
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.getElementById('qrModal').addEventListener('shown.bs.modal', function() {

            const referral = document.getElementById('qrReferralCode').value;
            const link = "{{ url('/tambah-jamaah') }}?ref=" + referral;

            document.getElementById('qrLink').value = link;

            const qrContainer = document.getElementById('qrCodeContainer');
            qrContainer.innerHTML = '';

            new QRCode(qrContainer, {
                text: link,
                width: 220,
                height: 220
            });
        });

        document.getElementById('downloadQR').addEventListener('click', function() {
            // QRCode.js membuat <img> atau <canvas>, kita ambil canvas
            const container = document.getElementById('qrCodeContainer');
            const img = container.querySelector('img');

            if (img) {
                // Buat link download
                const a = document.createElement('a');
                a.href = img.src;
                a.download = 'QR_Referral.png';
                a.click();
            } else {
                alert('QR Code belum siap.');
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

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
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-validasi');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const status = parseInt(this.dataset.status);

                    if (status === 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: 'Jamaah telah divalidasi!',
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Status validasi akan diubah menjadi 'Sudah'!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, validasi!'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            fetch(`/calon-jamaah/validasi/${id}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: data.message
                                    }).then(() => {
                                        location.reload();
                                    });
                                })
                                .catch(err => {
                                    Swal.fire('Error', 'Terjadi kesalahan!', 'error');
                                });

                        }
                    });
                });
            });
        });
    </script>
</body>

</html>