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
                                    <h3 class="card-title">Daftar Jamaah Berangkat</h3>

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
                                        text: "Jemaah Berhasil ditambahkan ke rombongan!",
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
                                        text: "Rombongan Berhasil diUpdate!",
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
                                        text: "Jamaah Berhasil diperbarui!",
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
                                @if (session('success_unvalidate'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success!",
                                        text: "Jemaah Berhasil Dihapus!",
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

                                        <div class="col-md-3">
                                            <label>Filter Rombongan</label>
                                            <select id="filterRombongan" class="form-control">
                                                <option value="">Semua</option>
                                                @foreach($rombongan as $r)
                                                <option value="{{ $r->kode_rombongan }}">
                                                    {{ $r->kode_rombongan }}
                                                </option>
                                                @endforeach
                                            </select>
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
                                                <th><input type="checkbox" id="checkAll"></th>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama Lengkap</th>
                                                <th class="text-center">Jenis Kelamin</th>
                                                <th class="text-center">Tanggal Lahir</th>
                                                <th class="text-center">No Telepon</th>
                                                <th class="text-center">Tanggal Keberangkatan</th>
                                                <th class="text-center">Rombongan</th>
                                                <th class="text-center">Status Keberangkatan</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jamaah as $index => $j)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="jamaah-checkbox" value="{{ $j->id }}">
                                                </td>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $j->nama_depan . ' ' . $j->nama_belakang }}</td>
                                                <td>
                                                    @if ($j->jenis_kelamin == 'L') Laki-laki
                                                    @elseif ($j->jenis_kelamin == 'P') Perempuan
                                                    @else Tidak diketahui
                                                    @endif
                                                </td>
                                                <td>{{ $j->tanggal_lahir ?? '-' }}</td>
                                                <td>{{ $j->kontak_darurat_hp ?? '-' }}</td>
                                                <td class="text-center">{{ $j->tgl_keberangkatan?? '-' }}</td>
                                                <td class="text-center">
                                                    @if ($j->id_rombongan)
                                                    <span>
                                                        {{ $j->id_rombongan }} <br>
                                                        <button class="btn btn-sm btn-info"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalRombongan"
                                                            data-id="{{ $j->id }}"
                                                            data-nama="{{ $j->nama_depan . ' ' . $j->nama_belakang }}"
                                                            data-rombongan="{{ $j->id_rombongan }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </span>
                                                    @else
                                                    <span class="badge bg-danger"
                                                        role="button"
                                                        style="cursor: pointer; font-size: 13px; padding: 7px 14px;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalRombongan"
                                                        data-id="{{ $j->id }}"
                                                        data-nama="{{ $j->nama_depan . ' ' . $j->nama_belakang }}"
                                                        data-rombongan="{{ $j->id_rombongan }}">
                                                        Belum Ada
                                                    </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">

                                                    @php
                                                    $today = \Carbon\Carbon::today();

                                                    $tglBerangkat = optional($j->rombongan)->tgl_keberangkatan
                                                    ? \Carbon\Carbon::parse($j->rombongan->tgl_keberangkatan)
                                                    : null;

                                                    $tglPulang = optional($j->rombongan)->tanggal_kembali
                                                    ? \Carbon\Carbon::parse($j->rombongan->tanggal_kembali)
                                                    : null;

                                                    $lengkap = !empty($j->foto_ktp) && !empty($j->foto_kk) && !empty($j->foto_paspor);
                                                    @endphp

                                                    {{-- PRIORITAS: BERKAS --}}
                                                    @if(!$lengkap)
                                                    <span class="badge bg-danger">Belum Lengkap</span>

                                                    <div class="text-xs text-danger mt-1">
                                                        @if(empty($j->foto_ktp)) KTP @endif
                                                        @if(empty($j->foto_kk)) KK @endif
                                                        @if(empty($j->foto_paspor)) Paspor @endif
                                                    </div>

                                                    {{-- SIAP BERANGKAT --}}
                                                    @elseif($tglBerangkat && $today->lt($tglBerangkat))
                                                    <span class="badge bg-info">Siap Berangkat</span>

                                                    {{-- SEDANG BERANGKAT --}}
                                                    @elseif($tglBerangkat && $tglPulang && $today->between($tglBerangkat, $tglPulang))
                                                    <span class="badge bg-warning">Sedang Berangkat</span>

                                                    {{-- SUDAH PULANG --}}
                                                    @elseif($tglPulang && $today->gt($tglPulang))
                                                    <span class="badge bg-success">Sudah Pulang</span>

                                                    @else
                                                    <span class="badge bg-secondary">Tidak diketahui</span>
                                                    @endif

                                                    <br>

                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('keberangkatan.unvalidate', $j->id) }}" method="POST" class="delete-form d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>

                                                    <!-- tombol untuk notifikasi WA individual -->
                                                    <button
                                                        type="button"
                                                        class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalNotifikasi"
                                                        data-id="{{ $j->id }}">
                                                        <i class="fas fa-phone"></i> Kirim Notif
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button
                                        type="button"
                                        class="btn btn-success mb-3"
                                        id="btnKirimNotifMassal"
                                        style="display: none;">
                                        <i class="fas fa-phone"></i> Kirim Notif ke Terpilih
                                    </button>
                                    <!-- Modal Tambah ke Rombongan -->
                                    <div class="modal fade" id="modalRombongan" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form id="formRombongan" method="POST">
                                                @csrf
                                                <input type="hidden" name="jamaah_id" id="jamaah_id">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="judulModal"></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        {{-- Pilih Rombongan --}}
                                                        <div class="mb-3">
                                                            <label for="select_rombongan">Pilih Rombongan</label>
                                                            <select class="form-control" id="select_rombongan" name="rombongan_id" required>
                                                                <option value="">-- Pilih --</option>
                                                                @foreach ($rombongan as $r)
                                                                <option value="{{ $r->kode_rombongan }}" data-pembimbing="{{ $r->pembimbing->nama_lengkap ?? '-' }}">
                                                                    {{ $r->nama_rombongan }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{-- Nama Pembimbing --}}
                                                        <div class="mb-3">
                                                            <label for="nama_pembimbing">Nama Pembimbing</label>
                                                            <input type="text" id="nama_pembimbing" class="form-control" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modalNotifikasi" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('Notifikasi_grup') }}">
                                                @csrf
                                                <input type="hidden" name="jamaah_id" id="jamaah_id">


                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Kirim Notifikasi WhatsApp</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <label>Pesan</label>
                                                        <textarea name="pesan" class="form-control" rows="8">Assalamu’alaikum Warahmatullahi Wabarakatuh
Yth. Bapak/Ibu Jamaah,

Sebagai media penyampaian informasi resmi terkait persiapan dan koordinasi keberangkatan, kami mengundang Bapak/Ibu untuk bergabung ke Grup WhatsApp Jamaah melalui tautan berikut:

👉 (link grup WhatsApp)

Kami mohon kesediaan Bapak/Ibu untuk bergabung agar informasi dapat diterima dengan baik dan tepat waktu.

Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.
Semoga Allah SWT senantiasa memudahkan dan memberkahi perjalanan ibadah Bapak/Ibu. 🤲

Wassalamu’alaikum Warahmatullahi Wabarakatuh
Manajemen Mahkota Trip</textarea>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            Kirim
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modalNotifikasiMassal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('Notifikasi_grup') }}">
                                                @csrf


                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Kirim Notifikasi WhatsApp</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <input type="hidden" name="jamaah_ids" id="jamaah_ids">

                                                        <label>Pesan</label>
                                                        <textarea name="pesan" class="form-control" rows="8">Assalamu’alaikum Warahmatullahi Wabarakatuh
Yth. Bapak/Ibu Jamaah,

Sebagai media penyampaian informasi resmi terkait persiapan dan koordinasi keberangkatan, kami mengundang Bapak/Ibu untuk bergabung ke Grup WhatsApp Jamaah melalui tautan berikut:

👉 (link grup WhatsApp)

Kami mohon kesediaan Bapak/Ibu untuk bergabung agar informasi dapat diterima dengan baik dan tepat waktu.

Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.
Semoga Allah SWT senantiasa memudahkan dan memberkahi perjalanan ibadah Bapak/Ibu. 🤲

Wassalamu’alaikum Warahmatullahi Wabarakatuh
Manajemen Mahkota Trip</textarea>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            Kirim
                                                        </button>
                                                    </div>
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
        const modalRombongan = document.getElementById('modalRombongan');
        const formRombongan = document.getElementById('formRombongan');
        const selectRombongan = document.getElementById('select_rombongan');
        const namaPembimbing = document.getElementById('nama_pembimbing');
        const judulModal = document.getElementById('judulModal');
        const namaJamaahLabel = document.getElementById('nama_jamaah_label');

        modalRombongan.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-id');
            let rombongan = button.getAttribute('data-rombongan'); // null jika insert

            document.getElementById('jamaah_id').value = id;

            if (rombongan) {
                // MODE EDIT
                formRombongan.action = "{{ route('rombongan.edit') }}";

                // Tambahkan method PUT jika belum ada
                if (!formRombongan.querySelector('input[name="_method"]')) {
                    let methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    formRombongan.appendChild(methodInput);
                }

                selectRombongan.value = rombongan;
            } else {
                // MODE INSERT
                formRombongan.action = "{{ route('rombongan.create') }}";

                // Hapus method PUT jika ada
                let methodInput = formRombongan.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                selectRombongan.value = "";
            }

            // Update nama pembimbing
            updatePembimbing();
        });


        // Update nama pembimbing saat dropdown berubah
        selectRombongan.addEventListener('change', updatePembimbing);

        function updatePembimbing() {
            let selected = selectRombongan.options[selectRombongan.selectedIndex];
            namaPembimbing.value = selected ? selected.dataset.pembimbing : "";
        }
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


            $('#filterRombongan').on('change', function() {
                table.column(7).search(this.value).draw();
            });

            $('#resetFilter').on('click', function() {
                $('#minDate').val('');
                $('#maxDate').val('');
                $('#filterRombongan').val('');
                table.draw();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnMassal = document.getElementById('btnKirimNotifMassal');
            const modalMassal = document.getElementById('modalNotifikasiMassal');
            const checkboxes = document.querySelectorAll('.jamaah-checkbox');
            const checkAll = document.getElementById('checkAll');

            // Fungsi untuk menampilkan/menyembunyikan tombol massal
            function toggleBtnMassal() {
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                btnMassal.style.display = anyChecked ? 'inline-block' : 'none';
            }

            // Event untuk setiap checkbox
            checkboxes.forEach(cb => {
                cb.addEventListener('change', toggleBtnMassal);
            });

            // Event untuk checkAll
            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    toggleBtnMassal();
                });
            }

            // Event klik tombol massal
            btnMassal.addEventListener('click', function(e) {
                const selected = Array.from(document.querySelectorAll('.jamaah-checkbox:checked'))
                    .map(cb => cb.value);

                if (selected.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops!',
                        text: 'Silakan pilih minimal satu jamaah terlebih dahulu.',
                        confirmButtonColor: '#3085d6'
                    });
                    return; // jangan tampilkan modal
                }

                // Pastikan input hidden ada di modal
                const inputJamaah = document.getElementById('jamaah_ids');
                if (inputJamaah) {
                    inputJamaah.value = selected.join(',');
                }

                // Tampilkan modal massal
                const bsModal = new bootstrap.Modal(modalMassal);
                bsModal.show();
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const modal = document.getElementById('modalNotifikasi');

            modal.addEventListener('show.bs.modal', function(event) {

                const button = event.relatedTarget;
                const jamaahId = button.getAttribute('data-id');

                const input = modal.querySelector('#jamaah_id');
                input.value = jamaahId;

            });

        });
    </script>


</body>

</html>