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
                                    <h3 class="card-title">Daftar Jamaah</h3>

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
                                @if (session('error_berkas'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: "Gagal!",
                                        text: "Berkas jamaah belum lengkap!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('error_pembayaran'))
                                <script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: "Gagal!",
                                        text: "Pembayaran jamaah belum lunas!",
                                        showConfirmButton: true,
                                    });
                                </script>
                                @endif
                                @if (session('success_hapus_jamaah'))
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
                                    <div class="mb-3">
                                        <a href="{{route('jamaah.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-user-plus"></i> Tambah Jamaah</a>
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
                                                <th class="text-center">Nama Lengkap</th>
                                                <th class="text-center">Jenis Kelamin</th>
                                                <th class="text-center">Tanggal Lahir</th>
                                                <!-- <th>Kebangsaan</th> -->
                                                <!-- <th class="text-center">Email</th> -->
                                                <th class="text-center">No Telepon</th>
                                                <th class="text-center">Paket</th>
                                                <th class="text-center">Berkas</th>
                                                <th class="text-center">Status Pembayaran</th>
                                                <th class="text-center">Status Logistik</th>
                                                <th class="text-center">Status Tiket</th>
                                                <th class="text-center">Status Asuransi</th>
                                                <th class="text-center">Status Visa</th>
                                                <th class="text-center">SISKOPATU</th>
                                                <th class="text-center">Status Validasi</th>
                                                <th class="text-center">Tanggal Keberangkatan</th>
                                                <!-- <th class="text-center">Id Marketing</th> -->
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jamaah as $index => $j)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $j->nama_depan . ' ' . $j->nama_belakang }}</td>
                                                <td>
                                                    @if ($j->jenis_kelamin == 'L')
                                                    Laki-laki
                                                    @elseif ($j->jenis_kelamin == 'P')
                                                    Perempuan
                                                    @else
                                                    Tidak diketahui
                                                    @endif
                                                </td>
                                                <td>{{ $j->tanggal_lahir ?? '-' }}</td>
                                                <!-- <td>{{ $j->kebangsaan ?? '-' }}</td> -->
                                                <!-- <td>{{ $j->email ?? '-' }}</td> -->
                                                <td>{{ $j->kontak_darurat_hp ?? '-' }}</td>
                                                <td>{{ $j->paket ?? '-' }}</td>
                                                <td class="text-center">

                                                    @php
                                                    $ktp = $j->foto_ktp ?? null;
                                                    $kk = $j->foto_kk ?? null;
                                                    $paspor = $j->foto_paspor ?? null;

                                                    $lengkap = $ktp && $kk && $paspor;
                                                    @endphp

                                                    @if($lengkap)
                                                    <span class="badge bg-success mb-1">Lengkap</span>
                                                    @else
                                                    <span class="badge bg-warning mb-1">Belum Lengkap</span>
                                                    @endif

                                                    <br>

                                                    <button class="btn btn-info btn-sm mt-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalBerkas{{ $j->id }}">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </button>

                                                </td>
                                                <td class="text-center">
                                                    @php
                                                    // Total pembayaran mandiri user
                                                    $totalUser = $j->payments()->sum('amount');

                                                    // Total pembayaran dibantu admin
                                                    $totalAdmin = $j->pembayarans()->sum('amount');

                                                    // Total keseluruhan
                                                    $terbayar = $totalUser + $totalAdmin;

                                                    // Target paket
                                                    $target = $j->pakets->harga_paket ?? 0;

                                                    // Persentase
                                                    $persen = $target > 0
                                                    ? min(100, round(($terbayar / $target) * 100))
                                                    : 0;

                                                    $sisa = max(0, $target - $terbayar);
                                                    @endphp

                                                    @if ($terbayar < $target)
                                                        <span class="badge bg-danger mb-1">Belum Lunas</span>
                                                        @else
                                                        <span class="badge bg-success mb-1">Lunas</span>
                                                        @endif

                                                        <div class="progress mt-1" style="height: 18px;">
                                                            <div class="progress-bar {{ $persen < 100 ? 'bg-warning' : 'bg-success' }}"
                                                                role="progressbar"
                                                                style="width: {{ $persen }}%;">
                                                                {{ $persen }}%
                                                            </div>
                                                        </div>

                                                        <small class="text-muted d-block mt-1">
                                                            Rp {{ number_format($terbayar, 0, ',', '.') }} /
                                                            Rp {{ number_format($target, 0, ',', '.') }}
                                                        </small>
                                                        <small class="text-danger d-block">
                                                            Sisa: Rp {{ number_format($sisa, 0, ',', '.') }}
                                                        </small>
                                                </td>

                                                <td class="text-center">
                                                    @if($j->status_logistik == 1)
                                                    <span class="badge bg-success">Sudah</span>
                                                    @elseif($j->status_logistik == 0)
                                                    <span class="badge bg-danger">Belum</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if($j->tiket)
                                                    <span class="badge bg-success">Sudah</span>
                                                    @else
                                                    <span class="badge bg-danger">Belum</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if(optional($j->rombongan)->status_asuransi == 1)
                                                    <span class="badge bg-success">Sudah</span>
                                                    @else
                                                    <span class="badge bg-danger">Belum</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if($j->status_visa == 1)
                                                    <span class="badge bg-success">Sudah</span>
                                                    @elseif($j->status_visa == 0)
                                                    <span class="badge bg-danger">Belum</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if($j->siskopatu)
                                                    <span class="badge bg-success">Sudah</span>
                                                    @else
                                                    <span class="badge bg-danger">Belum</span>
                                                    @endif
                                                </td>


                                                <td class="text-center">
                                                    @if($j->status_validasi == 1)
                                                    <span class="badge bg-success">Sudah</span>
                                                    @elseif($j->status_validasi == 0)
                                                    <span class="badge bg-danger">Belum</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    {{ $j->paket == 'Umroh Private' ? $j->tgl_keberangkatan : $j->pakets->tgl_berangkat }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('jamaah.edit', $j->id) }}" class="btn btn-warning btn-sm mb-2" style="min-width: 120px;">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>

                                                    <form action="{{ route('jamaah.delete', $j->id) }}" method="POST" class="delete-form d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm mb-2" style="min-width: 120px;">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>

                                                    <!-- <a href="{{ route('jamaah.edit', $j->id) }}" class="btn btn-info btn-sm mb-2" style="min-width: 120px;">
                                                        <i class="fas fa-info"></i> Info
                                                    </a> -->

                                                    <button class="btn btn-success btn-sm mb-2 btn-validasi"
                                                        data-id="{{ $j->id }}"
                                                        data-status="{{ $j->status_validasi }}"
                                                        style="min-width: 120px;">
                                                        <i class="fas fa-check"></i> Validasi
                                                    </button>

                                                    <a href="{{ route('jamaah.notif',$j->id) }}" class="btn btn-success btn-sm mb-2" style="min-width: 120px;">
                                                        <i class="fas fa-phone"></i> Kirim Notif
                                                    </a>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @foreach ($jamaah as $j)
                                    <div class="modal fade" id="modalBerkas{{ $j->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-file"></i>
                                                        Berkas {{ $j->nama_depan }} {{ $j->nama_belakang ?? '' }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body row text-center">

                                                    <div class="col-md-6 mb-3">
                                                        <h6>KTP</h6>
                                                        @if($j->foto_ktp)
                                                        <img src="{{ asset('storage/'.$j->foto_ktp) }}"
                                                            class="img-fluid rounded w-50">
                                                        @else
                                                        <span class="text-danger">Tidak ada</span>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <h6>Kartu Keluarga</h6>
                                                        @if($j->foto_kk)
                                                        <img src="{{ asset('storage/'.$j->foto_kk) }}"
                                                            class="img-fluid rounded w-50">
                                                        @else
                                                        <span class="text-danger">Tidak ada</span>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <h6>Paspor</h6>
                                                        @if($j->foto_paspor)
                                                        <img src="{{ asset('storage/'.$j->foto_paspor) }}"
                                                            class="img-fluid rounded w-50">
                                                        @else
                                                        <span class="text-danger">Tidak ada</span>
                                                        @endif
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
        document.addEventListener('submit', function(e) {

            const form = e.target.closest('.delete-form');
            if (!form) return;

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
    </script>

    <script>
        document.addEventListener('click', function(e) {

            const button = e.target.closest('.btn-validasi');

            if (!button) return;

            const id = button.dataset.id;
            const status = parseInt(button.dataset.status);

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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, validasi!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/validasi-jamaah/${id}`;
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
                    var date = data[9]; // index kolom "Tanggal Mendaftar"

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