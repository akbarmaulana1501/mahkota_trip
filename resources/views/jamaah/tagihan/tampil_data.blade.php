<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Auth::guard('jamaah')->user()->username ?? Auth::user()->name }} | Mahkota Trip</title>

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
                                    <h4 class="font-weight-bold">
                                        Tabungan
                                    </h4>
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



                                <div class="card-body">

                                    <!-- Judul -->
                                    <div class="mb-4">

                                        <p class="text-muted">
                                            Informasi pembayaran paket umrah Anda
                                        </p>
                                        <hr>
                                    </div>

                                    <!-- Ringkasan -->
                                    <div class="row text-center mb-4">

                                        <div class="col-md-4 mb-3">
                                            <div class="p-4 bg-light rounded">
                                                <h6 class="text-muted">Total Harga Paket</h6>
                                                <h4 class="font-weight-bold">
                                                    Rp {{ number_format($jamaah->pakets?->harga_paket ?? 0, 0, ',', '.') }}
                                                </h4>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="p-4 bg-light rounded">
                                                <h6 class="text-muted">Sudah Dibayar</h6>
                                                <h4 class="text-success font-weight-bold">
                                                    Rp {{ number_format($paid_total ?? 0, 0, ',', '.') }}
                                                </h4>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="p-4 bg-light rounded">
                                                <h6 class="text-muted">Sisa Tagihan</h6>
                                                <h4 class="text-danger font-weight-bold">
                                                    Rp {{ number_format(($jamaah->pakets?->harga_paket ?? 0) - ($paid_total ?? 0), 0, ',', '.') }}
                                                </h4>
                                            </div>
                                        </div>

                                    </div>


                                    <!-- Riwayat -->
                                    <div class="mb-4">
                                        <h6 class="font-weight-bold mb-3">
                                            Riwayat Tabungan
                                        </h6>

                                        <div class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Jumlah</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payment as $index => $p)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $p->created_at }}</td>
                                                        <td>Rp.{{ $p->amount ?? '-' }}</td>
                                                        <td class="text-center">
                                                            @if ($p->status == "paid")
                                                            <span class="badge bg-success">Paid</span>
                                                            @else
                                                            <span class="badge bg-danger">Pending</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Tombol -->
                                    <div class="text-center">
                                        <button id="pay-button" class="btn btn-success btn-lg px-5">
                                            💳 Menabung Sekarang
                                        </button>
                                        <button id="cek-button" class="btn btn-success btn-lg px-5">
                                            Cek Pembayaran
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
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
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        $('#pay-button').click(async function() {

            // 1️⃣ Munculkan input nominal (tetap sama tampilan)
            const {
                value: amount
            } = await Swal.fire({
                title: 'Masukkan jumlah tabungan',
                input: 'text', // ganti ke text supaya bisa format Rp
                inputLabel: 'Nominal (Rp)',
                inputPlaceholder: 'Contoh: 500.000',
                showCancelButton: true,
                focusConfirm: false,
                preConfirm: () => {
                    const val = Swal.getInput().value;
                    const clean = val.replace(/\D/g, ''); // hapus titik/koma
                    if (!clean || parseInt(clean) < 1000) {
                        Swal.showValidationMessage('Minimal tabungan Rp 1.000');
                        return false;
                    }
                    return clean; // string bersih
                },
                didOpen: () => {
                    const input = Swal.getInput();
                    input.addEventListener('input', function(e) {
                        let val = e.target.value.replace(/\D/g, ''); // hanya angka
                        if (val) {
                            e.target.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // format ribuan
                        } else {
                            e.target.value = '';
                        }
                    });
                }
            });

            if (!amount) return;

            // 2️⃣ Kirim ke server
            fetch('/generate-va', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: amount
                    })
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        title: "Transfer ke VA",
                        html: `
                <b>Bank:</b> ${data.bank.toUpperCase()} <br>
                <b>VA:</b> ${data.va} <br>
                <b>Nominal:</b> Rp ${data.amount} <br>
                <b>Berlaku sampai:</b> ${data.expired}
            `,
                        icon: "info"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // 🔄 Refresh tabel riwayat tabungan
                            $('#example1').DataTable().ajax.reload(null, false);
                        }
                    });
                })
                .catch(err => {
                    Swal.fire('Error', 'Gagal membuat VA', 'error');
                });

        });
    </script>
    <script>
        $('#cek-button').click(function() {

            fetch("{{ route('cekVA') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === 'empty') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Tidak Ada Pembayaran Aktif',
                            text: 'Silahkan buat tabungan baru'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Pembayaran Aktif',
                        html: `
                <p>Bank: <b>${data.bank}</b></p>
                <p>VA: <b>${data.va}</b></p>
                <p>Nominal: <b>Rp ${data.amount}</b></p>
                <p style="color:red">Berlaku sampai:<br>${data.expired}</p>
                <p>⏳ Sisa Waktu: <span id="countdown"></span></p>
            `,
                        icon: 'info',
                        didOpen: () => {

                            let expiredAt = new Date(data.expired_raw).getTime();

                            let x = setInterval(function() {

                                let now = new Date().getTime();
                                let distance = expiredAt - now;

                                if (distance < 0) {
                                    clearInterval(x);
                                    document.getElementById("countdown").innerHTML = "EXPIRED";
                                }

                                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                document.getElementById("countdown").innerHTML =
                                    hours + "j " + minutes + "m " + seconds + "d";

                            }, 1000);
                        }
                    });

                });

        });
    </script>

</body>

</html>