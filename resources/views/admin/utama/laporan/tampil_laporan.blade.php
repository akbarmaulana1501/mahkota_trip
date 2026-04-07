<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ auth()->user()->username }}</title>

    <!-- Google Font: Source Sans Pro -->
    @include('layouts.style')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>

<style>
    /* Jangan sentuh border cell */
    #example1 th,
    #example1 td {
        white-space: nowrap;
        vertical-align: middle;
    }

    /* Wrapper jangan pakai margin */
    .dataTables_wrapper {
        padding: 2px;
    }

    /* Scroll body TANPA margin */
    .dataTables_scrollBody {
        border: none !important;
    }

    /* Garis rapi pakai shadow tipis */
    .dataTables_scrollHead table {
        border-bottom: 1px solid #dee2e6;
    }

    .editable-text,
    .editable-date,
    .editable-select {
        cursor: pointer;
        min-width: 120px;
    }

    .editable-text:hover,
    .editable-date:hover,
    .editable-select:hover {
        background-color: #eef7ff;
    }

    /* Beri jarak antara tombol export dan length menu */
    .dataTables_wrapper .dt-buttons {
        margin-right: 15px;
        /* atau sesuai kebutuhan */
    }

    .dataTables_wrapper .dataTables_length {
        display: inline-block;
    }
</style>




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
                @if (session('success_update_laporan'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Data Jamaah Berhasil diperbarui!",
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


                        <!-- /.card -->
                        <div class="col-md-12">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan SISKOPATU</h3>
                                </div>
                                <!-- <form id="formCetak">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="tgl_awal">Tanggal Awal</label>
                                            <input type="date" class="form-control" id="tgl_awal" name="tgl_awal">
                                        </div>
                                        <div class="form-group">
                                            <label for="tgl_akhir">Tanggal Akhir</label>
                                            <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir">
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-file"></i> Cetak</button>
                                    </div>
                                </form> -->
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
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Aksi</th>
                                                    <th>Title</th>
                                                    <th>Nama</th>
                                                    <th>Nama Ayah</th>
                                                    <th>Jenis Identitas</th>
                                                    <th>No Identitas</th>
                                                    <th>Nama Paspor</th>
                                                    <th>No Paspor</th>
                                                    <th>Tgl Terbit Paspor</th>
                                                    <th>Kota Paspor</th>
                                                    <th>Tempat Lahir</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Alamat</th>
                                                    <th>Provinsi</th>
                                                    <th>Kabupaten</th>
                                                    <th>Kecamatan</th>
                                                    <th>No Telepon</th>
                                                    <th>No HP</th>
                                                    <th>Kewarganegaraan</th>
                                                    <th>Status Pernikahan</th>
                                                    <th>Pendidikan</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Pekerjaan Lainnya</th>
                                                    <th>Provider Visa</th>
                                                    <th>No Visa</th>
                                                    <th>Tgl Berlaku Visa</th>
                                                    <th>Tgl Akhir Visa</th>
                                                    <th>Asuransi</th>
                                                    <th>No Polis</th>
                                                    <th>Tgl Input Polis</th>
                                                    <th>Tgl Awal Polis</th>
                                                    <th>Tgl Akhir Polis</th>
                                                    <th>Tanggal Input</th>
                                                    <th>No BPJS</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($jamaah as $index => $j)
                                                <tr @if(!$j->siskopatu)
                                                    class="row-clickable table-warning"
                                                    data-id="{{ $j->id }}"
                                                    @endif >
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="text-center">
                                                        @if($j->siskopatu)
                                                        <!-- DATA SUDAH ADA → EDIT -->
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-warning btn-sm btn-edit"
                                                            data-id="{{ $j->siskopatu->id }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        @else
                                                        <!-- DATA BELUM ADA -->
                                                        <span class="text-danger" title="Data SISKOPATU belum ada">
                                                            <i class="fas fa-exclamation-circle fa-lg"></i>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $j->jenis_kelamin == 'L' ? 'Tuan' : ($j->jenis_kelamin == 'P' ? 'Nyonya' : '') }}</td>
                                                    <td>{{ $j->siskopatu?->nama_lengkap}}</td>
                                                    <td>{{ $j->siskopatu?->nama_ayah }}</td>
                                                    <td>{{ $j->siskopatu?->jenis_identitas }}</td>
                                                    <td>{{ $j->no_ktp }}</td>
                                                    <td>{{ $j->siskopatu?->nama_paspor }}</td>
                                                    <td>{{ $j->siskopatu?->no_paspor }}</td>
                                                    <td>{{ $j->siskopatu?->tgl_paspor }}</td>
                                                    <td>{{ $j->siskopatu?->kota_paspor }}</td>
                                                    <td>{{ $j->siskopatu?->tempat_lahir }}</td>
                                                    <td>{{ $j->tanggal_lahir }}</td>
                                                    <td>{{ $j->alamat_lengkap }}</td>
                                                    <td>{{ $j->siskopatu?->provinsi }}</td>
                                                    <td>{{ $j->siskopatu?->kabupaten }}</td>
                                                    <td>{{ $j->siskopatu?->kecamatan }}</td>
                                                    <td>{{ $j->siskopatu?->no_telepon }}</td>
                                                    <td>{{ $j->siskopatu?->no_hp }}</td>
                                                    <td>{{ $j->kewarganegaraan ?? 'Indonesia' }}</td>
                                                    <td>{{ $j->siskopatu?->status_pernikahan }}</td>
                                                    <td>{{ $j->siskopatu?->pendidikan }}</td>
                                                    <td>{{ $j->siskopatu?->pekerjaan }}</td>
                                                    <td>{{ $j->siskopatu?->pekerjaan_lainnya }}</td>
                                                    <td>{{ $j->siskopatu?->provider_visa }}</td>
                                                    <td>{{ $j->siskopatu?->no_visa }}</td>
                                                    <td>{{ optional($j->siskopatu?->tgl_awal_visa)->format('Y-m-d') ?? '-' }}</td>
                                                    <td>{{ optional($j->siskopatu?->tgl_akhir_visa)->format('Y-m-d') ?? '-' }}</td>
                                                    <td>{{ $j->siskopatu?->asuransi }}</td>
                                                    <td>{{ $j->siskopatu?->no_polis }}</td>
                                                    <td>{{ optional($j->siskopatu?->tgl_input_polis)->format('Y-m-d') ?? '-' }}</td>
                                                    <td>{{ optional($j->siskopatu?->tgl_awal_polis)->format('Y-m-d') ?? '-' }}</td>
                                                    <td>{{ optional($j->siskopatu?->tgl_akhir_polis)->format('Y-m-d') ?? '-' }}</td>
                                                    <td>{{ $j->siskopatu?->created_at->format('Y-m-d')}}</td>
                                                    <td>{{ $j->siskopatu?->no_bpjs }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="modal fade" id="modalEditJamaah" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">

                                    <form id="formEditJamaah" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_jamaah" id="id_jamaah" value="{{$j->id ?? ''}}">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitle">Edit Data Jamaah</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">

                                                {{-- KOLOM KIRI --}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" name="title" class="form-control">
                                                    </div>
                                                    <div class="form-group"><label>Nama Lengkap</label>
                                                        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control">
                                                    </div>
                                                    <div class="form-group"><label>Nama Ayah</label><input type="text" name="nama_ayah" class="form-control"></div>
                                                    <div class="form-group">
                                                        <label for="jenis_identitas">Jenis Identitas</label>
                                                        <select name="jenis_identitas" id="jenis_identitas" class="form-control">
                                                            <option value="" disabled selected>-- Pilih Jenis Identitas --</option>
                                                            <option value="KTP">KTP</option>
                                                            <option value="PASPOR">PASPOR</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group"><label>No Identitas</label><input type="text" name="no_identitas" id="no_identitas" class="form-control"></div>
                                                    <div class="form-group"><label>Nama Paspor</label><input type="text" name="nama_paspor" class="form-control"></div>
                                                    <div class="form-group"><label>No Paspor</label><input type="text" name="no_paspor" class="form-control"></div>
                                                    <div class="form-group"><label>Tanggal Terbit Paspor</label><input type="date" name="tgl_paspor" class="form-control"></div>
                                                    <div class="form-group"><label>Kota Paspor</label><input type="text" name="kota_paspor" class="form-control"></div>
                                                    <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control"></div>
                                                    <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tgl_lahir" class="form-control"></div>
                                                    <div class="form-group"><label>Alamat</label><textarea name="alamat_lengkap" class="form-control"></textarea></div>
                                                    <div class="form-group"><label>Tgl Input Polis</label><input type="date" name="tgl_input_polis" class="form-control"></div>
                                                    <div class="form-group"><label>Tgl Awal Polis</label><input type="date" name="tgl_awal_polis" class="form-control"></div>
                                                    <div class="form-group"><label>Tgl Akhir Polis</label><input type="date" name="tgl_akhir_polis" class="form-control"></div>
                                                    <div class="form-group"><label>No BPJS</label><input type="number" name="no_bpjs" class="form-control"></div>
                                                </div>

                                                {{-- KOLOM KANAN --}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Provinsi</label>
                                                        <select id="provinsi" name="provinsi" class="form-control">

                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kabupaten</label>
                                                        <select id="kabupaten" name="kabupaten" class="form-control">
                                                            <option value="">-- Pilih Kabupaten --</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Kecamatan</label>
                                                        <select id="kecamatan" name="kecamatan" class="form-control">
                                                            <option value="">-- Pilih Kecamatan --</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kelurahan</label>
                                                        <select id="kelurahan" name="kelurahan" class="form-control">
                                                            <option value="">-- Pilih kelurahan --</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group"><label>No Telepon</label><input type="number" name="no_telepon" class="form-control"></div>
                                                    <div class="form-group"><label>No HP</label><input type="number" name="no_hp" class="form-control"></div>
                                                    <div class="form-group"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan" class="form-control"></div>
                                                    <div class="form-group"><label>Status Pernikahan</label>
                                                        <select name="status_pernikahan" class="form-control">
                                                            <option value="" disabled selected>-- Pilih status pernikahan --</option>
                                                            <option value="0">Belum Menikah</option>
                                                            <option value="1">Menikah</option>
                                                            <option value="2">Cerai</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pendidikan</label>
                                                        <select name="pendidikan" class="form-control">
                                                            <option value="" disabled selected>-- Pilih pendidikan --</option>
                                                            <option value="1">SD</option>
                                                            <option value="2">SMP</option>
                                                            <option value="3">SMA</option>
                                                            <option value="4">D4/S1</option>
                                                            <option value="5">S2</option>
                                                            <option value="6">S3</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pekerjaan</label>
                                                        <select name="pekerjaan" id="pekerjaan" class="form-control">
                                                            <option value="">-- Pilih Pekerjaan --</option>
                                                            @foreach($pekerjaan as $p)
                                                            <option value="{{ $p->nama_pekerjaan }}">{{ $p->nama_pekerjaan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group d-none" id="pekerjaan-lainnya-group">
                                                        <label>Pekerjaan Lainnya</label>
                                                        <input type="text" name="pekerjaan_lainnya" id="pekerjaan_lainnya" class="form-control">
                                                    </div>

                                                    <div class="form-group"><label>Provider Visa</label><input type="text" name="provider_visa" class="form-control"></div>
                                                    <div class="form-group"><label>No Visa</label><input type="text" name="no_visa" class="form-control"></div>
                                                    <div class="form-group"><label>Tgl Berlaku Visa</label><input type="date" name="tgl_awal_visa" class="form-control"></div>
                                                    <div class="form-group"><label>Tgl Akhir Visa</label><input type="date" name="tgl_akhir_visa" class="form-control"></div>
                                                    <div class="form-group"><label>Asuransi</label><input type="text" name="asuransi" class="form-control"></div>
                                                    <div class="form-group"><label>No Polis</label><input type="text" name="no_polis" class="form-control"></div>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" id="btnSubmit" data-mode="insert">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Batal
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.col -->
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        $(function() {

            let table = $('#example1').DataTable({
                scrollX: true,
                scrollY: '55vh',
                scrollCollapse: true,
                autoWidth: false,
                paging: true,
                pageLength: 10,
                fixedHeader: false, // WAJIB MATI kalau scrollY
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya",
                        "buttons": ["copy", "csv", "excel", "pdf"]
                    }
                },
                dom: 'Blfrtip', // diperlukan untuk menampilkan tombol
                buttons: [
                    'csv', 'excel', 'pdf'
                ]
            });

            table.columns.adjust();

        });
    </script>
    <script>
        $(document).on('click', '.row-clickable', function() {
            let id = $(this).data('id');

            $('#formEditJamaah')[0].reset();

            $('#formEditJamaah').attr('data-id', id);

            // Set action form
            $('#formEditJamaah').attr('action', '/laporan/');
            $('#modalTitle').text('Tambah Data SISKOPATU');
            $('#btnSubmit').removeClass('btn-warning').addClass('btn-success')
                .html('<i class="fas fa-save"></i> Simpan')
                .attr('data-mode', 'insert');

            // Ambil data via AJAX GET
            $.ajax({
                url: '/laporan/' + id + '/edit', // pastikan route ini sesuai route edit di Laravel
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (!data) return;
                    // Isi semua field modal
                    $('[name=id_jamaah]').val(data.id);
                    $('[name=title]').val(data.jenis_kelamin === 'L' ? 'Tuan' : (data.jenis_kelamin === 'P' ? 'Nyonya' : ''));
                    $('[name=nama_lengkap]').val(data.nama_depan + (data.nama_belakang ? ' ' + data.nama_belakang : ''));
                    $('[name=jenis_identitas]').val(data.siskopatu?.jenis_identitas ?? '');
                    $('[name=no_identitas]').val(data.siskopatu?.no_identitas ?? '');
                    $('[name=nama_ayah]').val(data.siskopatu?.nama_ayah ?? '');
                    $('[name=nama_paspor]').val(data.siskopatu?.nama_paspor ?? '');
                    $('[name=no_paspor]').val(data.siskopatu?.no_paspor ?? '');
                    $('[name=tgl_paspor]').val(data.siskopatu?.tgl_paspor ?? '');
                    $('[name=kota_paspor]').val(data.siskopatu?.kota_paspor ?? '');
                    $('[name=tempat_lahir]').val(data.siskopatu?.tempat_lahir ?? '');
                    $('[name=tgl_lahir]').val(data.tanggal_lahir ?? '');
                    $('[name=alamat_lengkap]').val(data.alamat_lengkap ?? '');
                    $('[name=no_telepon]').val(data.kontak_darurat_hp ?? '');
                    $('[name=no_hp]').val(data.kontak_darurat_hp ?? '');
                    let prov = data.siskopatu?.provinsi;
                    let kab = data.siskopatu?.kabupaten;
                    let kec = data.siskopatu?.kecamatan;
                    let kel = data.siskopatu?.kelurahan;
                    if (prov) {
                        loadProvinsi()
                            .then(() => {
                                $('[name=provinsi]').val(prov);
                                return loadKabupaten(prov);
                            })
                            .then(() => {
                                $('[name=kabupaten]').val(kab);
                                return loadKecamatan(kab);
                            })
                            .then(() => {
                                $('[name=kecamatan]').val(kec);
                                return loadKelurahan(kec);
                            })
                            .then(() => {
                                $('[name=kelurahan]').val(kel);
                            });
                    }
                    $('[name=kewarganegaraan]').val('WNI');
                    $('[name=status_pernikahan]').val(data.siskopatu?.status_pernikahan ?? '');
                    $('[name=pendidikan]').val(data.siskopatu?.pendidikan ?? '');
                    $('[name=pekerjaan]').val(data.siskopatu?.pekerjaan ?? '');
                    $('[name=pekerjaan_lainnya]').val(data.siskopatu?.pekerjaan_lainnya ?? '');
                    $('[name=provider_visa]').val('PT. RIAU WISATA HATI');
                    $('[name=no_visa]').val(data.siskopatu?.no_visa ?? '');
                    $('[name=tgl_awal_visa]').val(formatDate(data.siskopatu?.tgl_awal_visa));
                    $('[name=tgl_akhir_visa]').val(formatDate(data.siskopatu?.tgl_akhir_visa));
                    $('[name=asuransi]').val('ASURANSI TAKAFUL UMUM');
                    $('[name=no_polis]').val(data.siskopatu?.no_polis ?? '');
                    $('[name=tgl_input_polis]').val(formatDate(data.siskopatu?.tgl_input_polis));
                    $('[name=tgl_awal_polis]').val(formatDate(data.siskopatu?.tgl_awal_polis));
                    $('[name=tgl_akhir_polis]').val(formatDate(data.siskopatu?.tgl_akhir_polis));
                    $('[name=no_bpjs]').val(data.siskopatu?.no_bpjs ?? '');

                    // Tampilkan modal
                    let myModal = new bootstrap.Modal(document.getElementById('modalEditJamaah'));
                    myModal.show();
                },
                error: function(xhr, status, error) {
                    console.error('Gagal mengambil data:', error);
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let id = $(this).data('id');

            $('#formEditJamaah').attr('data-id', id);

            // Reset form
            $('#formEditJamaah')[0].reset();

            // Set action form untuk update
            $('#formEditJamaah').attr('action', '/laporan/' + id); // route update
            $('#modalTitle').text('Edit Data SISKOPATU');
            $('#btnSubmit').removeClass('btn-success').addClass('btn-warning')
                .html('<i class="fas fa-edit"></i> Update')
                .attr('data-mode', 'update');

            // Isi field dari data Jamaah + Siskopatu via AJAX
            $.ajax({
                url: '/laporan/' + id + '/edit',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('[name=title]').val(data.siskopatu?.title);
                    $('[name=nama_lengkap]').val(data.siskopatu?.nama_lengkap);
                    $('[name=nama_ayah]').val(data.siskopatu?.nama_ayah ?? '');
                    $('[name=jenis_identitas]').val(data.siskopatu?.jenis_identitas ?? '');
                    $('[name=no_identitas]').val(data.siskopatu?.no_identitas ?? '');
                    $('[name=nama_paspor]').val(data.siskopatu?.nama_paspor ?? '');
                    $('[name=no_paspor]').val(data.siskopatu?.no_paspor ?? '');
                    $('[name=tgl_paspor]').val(formatDate(data.siskopatu?.tgl_paspor));
                    $('[name=kota_paspor]').val(data.siskopatu?.kota_paspor ?? '');
                    $('[name=tempat_lahir]').val(data.siskopatu?.tempat_lahir ?? '');
                    $('[name=tgl_lahir]').val(formatTanggal(data.siskopatu?.tanggal_lahir ?? ''));
                    $('[name=alamat_lengkap]').val(data.siskopatu?.alamat_lengkap ?? '');
                    $('[name=no_telepon]').val(data.siskopatu?.kontak_darurat_hp ?? '');
                    $('[name=no_hp]').val(data.siskopatu?.kontak_darurat_hp ?? '');
                    let prov = data.siskopatu?.provinsi;
                    let kab = data.siskopatu?.kabupaten;
                    let kec = data.siskopatu?.kecamatan;
                    let kel = data.siskopatu?.kelurahan;
                    if (prov) {
                        loadProvinsi()
                            .then(() => {
                                $('[name=provinsi]').val(prov);
                                return loadKabupaten(prov);
                            })
                            .then(() => {
                                $('[name=kabupaten]').val(kab);
                                return loadKecamatan(kab);
                            })
                            .then(() => {
                                $('[name=kecamatan]').val(kec);
                                return loadKelurahan(kec);
                            })
                            .then(() => {
                                $('[name=kelurahan]').val(kel);
                            });
                    }
                    $('[name=kewarganegaraan]').val('WNI');
                    $('[name=status_pernikahan]').val(data.siskopatu?.status_pernikahan ?? '');
                    $('[name=pendidikan]').val(data.siskopatu?.pendidikan ?? '');
                    $('[name=pekerjaan]').val(data.siskopatu?.pekerjaan ?? '');
                    $('[name=pekerjaan_lainnya]').val(data.siskopatu?.pekerjaan_lainnya ?? '');
                    $('[name=provider_visa]').val('PT. RIAU WISATA HATI');
                    $('[name=no_visa]').val(data.siskopatu?.no_visa ?? '');
                    $('[name=tgl_awal_visa]').val(formatDate(data.siskopatu?.tgl_awal_visa));
                    $('[name=tgl_akhir_visa]').val(formatDate(data.siskopatu?.tgl_akhir_visa));
                    $('[name=asuransi]').val('ASURANSI TAKAFUL UMUM');
                    $('[name=no_polis]').val(data.siskopatu?.no_polis ?? '');
                    $('[name=tgl_input_polis]').val(formatDate(data.siskopatu?.tgl_input_polis));
                    $('[name=tgl_awal_polis]').val(formatDate(data.siskopatu?.tgl_awal_polis));
                    $('[name=tgl_akhir_polis]').val(formatDate(data.siskopatu?.tgl_akhir_polis));
                    $('[name=no_bpjs]').val(data.siskopatu?.no_bpjs ?? '');

                    // Tampilkan modal
                    let myModal = new bootstrap.Modal(document.getElementById('modalEditJamaah'));
                    myModal.show();
                }
            });
        });

        function formatDate(date) {
            return date ? date.substring(0, 10) : '';
        }

        function formatTanggal(date) {
            if (!date) return '';
            // ambil 10 karakter pertama dari format 'YYYY-MM-DD HH:MM:SS'
            return date.substring(0, 10);
        }
    </script>
    <script>
        function loadProvinsi() {
            return $.getJSON(
                'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
                function(res) {
                    let opt = '<option value="">-- Pilih Provinsi --</option>';
                    res.forEach(v => {
                        opt += `<option value="${v.id}">${v.name}</option>`;
                    });
                    $('[name=provinsi]').html(opt);
                }
            );
        }

        function loadKabupaten(provinsiId) {
            return $.getJSON(
                `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinsiId}.json`,
                function(res) {
                    let opt = '<option value="">-- Pilih Kabupaten --</option>';
                    res.forEach(v => {
                        opt += `<option value="${v.id}">${v.name}</option>`;
                    });
                    $('[name=kabupaten]').html(opt);
                }
            );
        }

        function loadKecamatan(kabupatenId) {
            return $.getJSON(
                `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabupatenId}.json`,
                function(res) {
                    let opt = '<option value="">-- Pilih Kecamatan --</option>';
                    res.forEach(v => {
                        opt += `<option value="${v.id}">${v.name}</option>`;
                    });
                    $('[name=kecamatan]').html(opt);
                }
            );
        }

        function loadKelurahan(kecamatanId) {
            return $.getJSON(
                `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`,
                function(res) {
                    let opt = '<option value="">-- Pilih Kelurahan --</option>';
                    res.forEach(v => {
                        opt += `<option value="${v.id}">${v.name}</option>`;
                    });
                    $('[name=kelurahan]').html(opt);
                }
            );
        }
    </script>

    <!-- <script>
        $('#formEditJamaah').submit(function(e) {
            e.preventDefault();
            let id = $('[name=id_jamaah]').val();
            let url = '/laporan/' + id; // HARUS SESUAI route PUT
            let formData = $(this).serializeArray();
            formData.push({
                name: '_method',
                value: 'PUT'
            });


            $.ajax({
                url: url,
                type: 'POST', // HARUS POST, Laravel baca _method
                data: $.param(formData),
                success: function(res) {
                    alert('Data berhasil diperbarui!');
                    $('#modalEditJamaah').modal('hide');
                    location.reload();
                },
                error: function(err) {
                    console.log(err);
                    alert('Gagal memperbarui data.');
                }
            });
        });
    </script> -->
    <script>
        $('#formEditJamaah').on('submit', function(e) {
            e.preventDefault();

            let mode = $('#btnSubmit').attr('data-mode'); // insert / update
            let id = $('#formEditJamaah').attr('data-id');

            let url = (mode === 'update') ?
                '/laporan/' + id :
                "{{ route('laporan.store') }}";

            let method = (mode === 'update') ? 'PUT' : 'POST';

            let formData = $(this).serializeArray();

            if (mode === 'update') {
                formData.push({
                    name: '_method',
                    value: 'PUT'
                });
            }

            $.ajax({
                url: url,
                type: 'POST', // SELALU POST, PUT via spoofing
                data: formData,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: mode === 'update' ?
                            'Data berhasil diperbarui!' : 'Data berhasil ditambahkan!',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        $('#modalEditJamaah').modal('hide');
                        location.reload();
                    });
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Data gagal disimpan!'
                    });
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Saat Jenis Identitas berubah
            $('#jenis_identitas').change(function() {
                let jenis = $(this).val();
                let jamaahId = $('#formEditJamaah').attr('data-id');

                if (jenis === 'KTP' && jamaahId) {
                    $.get('/jamaah/' + jamaahId + '/no-ktp', function(data) {
                        $('#no_identitas').val(data.no_ktp);
                    });
                } else {
                    $('#no_identitas').val('');
                }
            });

            // Saat modal ditutup → reset form
            $('#modalEditJamaah').on('hidden.bs.modal', function() {
                // Kosongkan input dan select
                $('#formEditJamaah')[0].reset();

                // Hapus data-id di form
                $('#formEditJamaah').removeAttr('data-id');

                // Kosongkan no_identitas
                $('#no_identitas').val('');
            });
        });

        $(document).ready(function() {

            // Load Provinsi
            $.getJSON('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', function(data) {
                $('#provinsi').append('<option value="">-- Pilih Provinsi --</option>');
                $.each(data, function(i, prov) {
                    $('#provinsi').append(`<option value="${prov.id}">${prov.name}</option>`);
                });
            });

            // Load Kabupaten
            $('#provinsi').change(function() {
                let provId = $(this).val();

                $('#kabupaten').html('<option value="">-- Pilih Kabupaten --</option>');
                $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
                $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');

                if (!provId) return;

                $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`, function(data) {
                    $.each(data, function(i, kab) {
                        $('#kabupaten').append(`<option value="${kab.id}">${kab.name}</option>`);
                    });
                });
            });

            // Load Kecamatan
            $('#kabupaten').change(function() {
                let kabId = $(this).val();

                $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
                $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');

                if (!kabId) return;

                $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabId}.json`, function(data) {
                    $.each(data, function(i, kec) {
                        $('#kecamatan').append(`<option value="${kec.id}">${kec.name}</option>`);
                    });
                });
            });

            $('#kecamatan').change(function() {
                let kecId = $(this).val();

                $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');

                if (!kecId) return;

                $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`, function(data) {
                    $.each(data, function(i, kel) {
                        $('#kelurahan').append(`<option value="${kel.id}">${kel.name}</option>`);
                    });
                });
            });

        });
    </script>


    <script>
        $(document).ready(function() {
            $('#pekerjaan').change(function() {
                let val = $(this).val();

                if (val === 'Lainnya') {
                    $('#pekerjaan-lainnya-group').removeClass('d-none');
                } else {
                    $('#pekerjaan-lainnya-group').addClass('d-none');
                    $('#pekerjaan_lainnya').val('');
                }
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
                    var date = data[33]; // index kolom "Tanggal Mendaftar"

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