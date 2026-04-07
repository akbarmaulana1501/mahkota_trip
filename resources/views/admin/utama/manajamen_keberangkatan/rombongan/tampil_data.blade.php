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
                                    <h3 class="card-title">Daftar Rombongan</h3>

                                </div>

                                @if (session('success'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Jemaah Berhasil ditambah!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('success_rombongan'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Rombongan Berhasil ditambahkan!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('success_update_rombongan'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Rombongan Berhasil diperbarui!",
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
                                @if (session('success_hapus_rombongan'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Rombongan Berhasil Dihapus!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-sm btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tambahRombonganModal">
                                            <i class="fa fa-users"></i> Tambah Rombongan
                                        </button>
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
                                                <th class="text-center">Kode Rombongan</th>
                                                <th class="text-center">Nama Rombongan</th>
                                                <th class="text-center">Paket</th>
                                                <th class="text-center">Nama Pembimbing</th>
                                                <th class="text-center">Tanggal Keberangkatan</th>
                                                <th class="text-center">Tanggal Kembali</th>
                                                <th class="text-center">Jumlah Jamaah</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rombongan as $index => $r)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $r->kode_rombongan }}</td>
                                                <td>{{ $r->nama_rombongan ?? '-' }}</td>
                                                <td>{{ $r->paket->nama_paket ?? '-' }}</td>
                                                <td>
                                                    @foreach([
                                                    $r->pembimbing,
                                                    $r->pembimbing2,
                                                    $r->pembimbing3,
                                                    $r->pembimbing4,
                                                    $r->pembimbing5
                                                    ] as $p)

                                                    @if($p)
                                                    <span class="badge bg-info">{{ $p->nama_lengkap }}</span>
                                                    @endif

                                                    @endforeach
                                                </td>
                                                <td class="text-center">{{ $r->tgl_keberangkatan ? date('Y-m-d', strtotime($r->tgl_keberangkatan)) : '-' }}</td>
                                                <td class="text-center">{{ $r->tanggal_kembali ? date('Y-m-d', strtotime($r->tanggal_kembali)) : '-' }}</td>
                                                <td>{{ $r->jumlah_jamaah ?? 0 }}</td>
                                                <td class="text-center">
                                                    <button
                                                        class="btn btn-warning btn-sm mb-2 btnEditRombongan"
                                                        style="min-width:120px;"
                                                        data-id="{{ $r->id }}"
                                                        data-kode="{{ $r->kode_rombongan }}"
                                                        data-nama="{{ $r->nama_rombongan }}"
                                                        data-paket="{{ $r->id_paket }}"
                                                        data-pembimbing1="{{ $r->id_pembimbing }}"
                                                        data-pembimbing2="{{ $r->id_pembimbing2 }}"
                                                        data-pembimbing3="{{ $r->id_pembimbing3 }}"
                                                        data-pembimbing4="{{ $r->id_pembimbing4 }}"
                                                        data-pembimbing5="{{ $r->id_pembimbing5 }}"
                                                        data-berangkat="{{ $r->tgl_keberangkatan ? \Carbon\Carbon::parse($r->tgl_keberangkatan)->format('Y-m-d') : '' }}"
                                                        data-kembali="{{ $r->tanggal_kembali ? \Carbon\Carbon::parse($r->tanggal_kembali)->format('Y-m-d') : '' }}"
                                                        data-jumlah="{{ $r->jumlah_jamaah }}"
                                                        data-bs-toggle="modal" data-bs-target="#tambahRombonganModal">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>

                                                    <form action="{{ route('rombongan.delete', $r->id) }}" method="POST" class="delete-form d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm mb-2" style="min-width: 120px;">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal fade" id="tambahRombonganModal" tabindex="-1" aria-labelledby="tambahRombonganModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form id="formRombongan" method="POST">
                                            @csrf
                                            <input type="hidden" name="rombongan_id" id="rombongan_id">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tambahRombonganModalLabel">Tambah Rombongan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="kode_rombongan" class="form-label">Kode Rombongan</label>
                                                        <input type="text" class="form-control" id="kode_rombongan" name="kode_rombongan" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nama_rombongan" class="form-label">Nama Rombongan</label>
                                                        <input type="text" class="form-control" id="nama_rombongan" name="nama_rombongan" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="id_paket" class="form-label">Paket</label>
                                                        <select class="form-control" id="id_paket" name="id_paket" required>
                                                            <option value="">-- Pilih Paket --</option>
                                                            @foreach($paket as $p)
                                                            <option value="{{ $p->id }}">{{ $p->nama_paket }} ({{ $p->tgl_berangkat }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="pembimbing_1" class="form-label">Pembimbing 1</label>
                                                        <select class="form-control pembimbing-select" id="pembimbing_1" name="id_pembimbing" required>
                                                            <option value="">-- Pilih Pembimbing 1 --</option>
                                                            @foreach($pembimbing as $b)
                                                            <option value="{{ $b->id }}">{{ $b->nama_lengkap }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="pembimbing_2" class="form-label">Pembimbing 2</label>
                                                        <select class="form-control pembimbing-select" id="pembimbing_2" name="id_pembimbing2">
                                                            <option value="">-- Pilih Pembimbing 2 --</option>
                                                            @foreach($pembimbing as $b)
                                                            <option value="{{ $b->id }}">{{ $b->nama_lengkap }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="pembimbing_3" class="form-label">Pembimbing 3</label>
                                                        <select class="form-control pembimbing-select" id="pembimbing_3" name="id_pembimbing3">
                                                            <option value="">-- Pilih Pembimbing 3 --</option>
                                                            @foreach($pembimbing as $b)
                                                            <option value="{{ $b->id }}">{{ $b->nama_lengkap }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="pembimbing_4" class="form-label">Pembimbing 4</label>
                                                        <select class="form-control pembimbing-select" id="pembimbing_4" name="id_pembimbing4">
                                                            <option value="">-- Pilih Pembimbing 4 --</option>
                                                            @foreach($pembimbing as $b)
                                                            <option value="{{ $b->id }}">{{ $b->nama_lengkap }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="pembimbing_5" class="form-label">Pembimbing 5</label>
                                                        <select class="form-control pembimbing-select" id="pembimbing_5" name="id_pembimbing5">
                                                            <option value="">-- Pilih Pembimbing 5 --</option>
                                                            @foreach($pembimbing as $b)
                                                            <option value="{{ $b->id }}">{{ $b->nama_lengkap }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="tgl_keberangkatan" class="form-label">Tanggal Keberangkatan</label>
                                                        <input type="date" class="form-control" id="tgl_keberangkatan" name="tgl_keberangkatan" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                                        <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="jumlah_jamaah" class="form-label">Jumlah Jamaah</label>
                                                        <input type="number" class="form-control" id="jumlah_jamaah" name="jumlah_jamaah" min="1" required>
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
        const modalRombongan = document.getElementById('tambahRombonganModal');

        modalRombongan.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');

            const form = document.getElementById('formRombongan');
            const title = document.getElementById('tambahRombonganModalLabel');

            // reset selalu di awal
            form.reset();

            // isi data
            document.getElementById('kode_rombongan').value = button.getAttribute('data-kode') || "";
            document.getElementById('nama_rombongan').value = button.getAttribute('data-nama') || "";
            document.getElementById('id_paket').value = button.getAttribute('data-paket') || "";
            document.getElementById('tgl_keberangkatan').value = button.getAttribute('data-berangkat') || "";
            document.getElementById('tanggal_kembali').value = button.getAttribute('data-kembali') || "";
            document.getElementById('jumlah_jamaah').value = button.getAttribute('data-jumlah') || "";

            document.getElementById('pembimbing_1').value =
                button.getAttribute('data-pembimbing1') || "";

            document.getElementById('pembimbing_2').value =
                button.getAttribute('data-pembimbing2') || "";

            document.getElementById('pembimbing_3').value =
                button.getAttribute('data-pembimbing3') || "";

            document.getElementById('pembimbing_4').value =
                button.getAttribute('data-pembimbing4') || "";

            document.getElementById('pembimbing_5').value =
                button.getAttribute('data-pembimbing5') || "";

            // trigger ulang logic disable select
            document.getElementById('pembimbing_1').dispatchEvent(new Event('change'));
            document.getElementById('pembimbing_2').dispatchEvent(new Event('change'));
            document.getElementById('pembimbing_3').dispatchEvent(new Event('change'));
            document.getElementById('pembimbing_4').dispatchEvent(new Event('change'));
            document.getElementById('pembimbing_5').dispatchEvent(new Event('change'));

            if (id) {
                // EDIT
                title.textContent = "Edit Rombongan";
                form.action = "{{ url('rombongan/update') }}/" + id;

                if (!form.querySelector('input[name="_method"]')) {
                    form.insertAdjacentHTML(
                        'beforeend',
                        '<input type="hidden" name="_method" value="PUT">'
                    );
                }

                document.getElementById('rombongan_id').value = id;
            } else {
                // TAMBAH
                title.textContent = "Tambah Rombongan";
                form.action = "{{ route('rombongan.store') }}";

                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                document.getElementById('rombongan_id').value = "";
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('.pembimbing-select');

            function updateOptions() {
                let selectedValues = [];

                selects.forEach(select => {
                    if (select.value) {
                        selectedValues.push(select.value);
                    }
                });

                selects.forEach(select => {
                    select.querySelectorAll('option').forEach(option => {
                        if (
                            option.value !== "" &&
                            selectedValues.includes(option.value) &&
                            option.value !== select.value
                        ) {
                            option.disabled = true;
                        } else {
                            option.disabled = false;
                        }
                    });
                });
            }

            selects.forEach(select => {
                select.addEventListener('change', updateOptions);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paketSelect = document.getElementById('id_paket');
            const tglBerangkat = document.getElementById('tgl_keberangkatan');
            const jumlahJamaah = document.getElementById('jumlah_jamaah');

            paketSelect.addEventListener('change', function() {
                const paketId = this.value;

                if (!paketId) {
                    tglBerangkat.value = '';
                    jumlahJamaah.value = '';
                    return;
                }

                fetch(`/paket/${paketId}/info`)
                    .then(response => response.json())
                    .then(data => {
                        tglBerangkat.value = data.tgl_berangkat;
                        jumlahJamaah.value = data.jumlah_jamaah;
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Gagal mengambil data paket');
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const modal = document.getElementById('tambahRombonganModal');

            modal.addEventListener('show.bs.modal', function() {

                // kosongkan dulu biar tidak nampilkan data lama
                document.getElementById('kode_rombongan').value = 'Loading...';

                fetch('/generate-kode-rombongan')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('kode_rombongan').value = data.kode;
                    })
                    .catch(error => {
                        console.error(error);
                        document.getElementById('kode_rombongan').value = 'Error';
                    });

            });

        });
    </script>


</body>

</html>