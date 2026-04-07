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
                        <div class="col-6">
                            @if (session('success_maskapai'))
                            <script>
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Success!",
                                    text: "Maskapai Berhasil ditambah!",
                                    showConfirmButton: true,
                                });
                            </script>
                            @endif
                            <!-- /.card -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Paket</h3>
                                </div>

                                <div class="card-body">

                                    <form action="{{ route('paket.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Nama Paket</label>
                                            <input type="text" name="nama_paket" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Jenis Paket</label>
                                            <select name="jenis_paket" id="jenis_paket" class="form-control" required>
                                                <option value="" disabled selected>Pilih</option>
                                                <option value="haji">Haji</option>
                                                <option value="private">Umroh Private</option>
                                                <option value="gold">Umroh Gold</option>
                                                <option value="silver">Umroh Silver</option>
                                                <option value="bronze">Umroh Bronze</option>
                                            </select>
                                        </div>

                                        <!-- <div id="jenis_umroh" style="display: none;">
                                            <div class="form-group">
                                                <label>Jenis Paket Umroh</label>
                                                <select name="paket_umroh" id="paket_umroh" class="form-control" required>
                                                    <option value="" disabled selected>Pilih</option>
                                                    <option value="gold">Gold</option>
                                                    <option value="silver">Silver</option>
                                                    <option value="bronze">Bronze</option>
                                                </select>
                                            </div>
                                        </div>

                                        <script>
                                            document.getElementById('jenis_paket').addEventListener('change', function() {
                                                const jenisUmrohDiv = document.getElementById('jenis_umroh');
                                                const paketUmrohSelect = document.getElementById('paket_umroh');

                                                if (this.value === 'umroh') {
                                                    jenisUmrohDiv.style.display = 'block';
                                                    paketUmrohSelect.required = true;
                                                } else {
                                                    jenisUmrohDiv.style.display = 'none';
                                                    paketUmrohSelect.required = false;
                                                    paketUmrohSelect.value = '';
                                                }
                                            });
                                        </script> -->

                                        <div class="form-group">
                                            <label>Tanggal Berangkat</label>
                                            <input type="date" name="tanggal_berangkat" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Kuota</label>
                                            <input type="number" name="kuota" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Hotel Mekkah</label>
                                            <input type="text" name="hotel_mekkah" id="hotel_mekkah" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>Hotel Madinah</label>
                                            <input type="text" name="hotel_madinah" id="hotel_madinah" class="form-control">
                                        </div>

                                        <input type="hidden" name="lat_mekkah" id="lat_mekkah">
                                        <input type="hidden" name="lng_mekkah" id="lng_mekkah">
                                        <input type="hidden" name="lat_madinah" id="lat_madinah">
                                        <input type="hidden" name="lng_madinah" id="lng_madinah">

                                        <div class="form-group">
                                            <label>Harga Paket</label>
                                            <input type="text" name="harga" id="harga" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                                    </form>

                                </div>
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
        const hotelData = {
            gold: {
                mekkah: {
                    name: 'Le Meridien',
                    lat: 21.420627230335835,
                    lng: 39.829335886507536
                },
                madinah: {
                    name: 'Al Ritz Madinah',
                    lat: 24.473468132939043,
                    lng: 39.610490615343394
                }
            },
            silver: {
                mekkah: {
                    name: 'Mira Ajyad',
                    lat: 21.420819954573503,
                    lng: 39.830449830686774
                },
                madinah: {
                    name: 'Dar Al Naeem',
                    lat: 24.473745637901846,
                    lng: 39.61271612883585
                }
            },
            bronze: {
                mekkah: {
                    name: 'Jada Ajyad',
                    lat: 21.420923303523857,
                    lng: 39.832519471164154
                },
                madinah: {
                    name: 'Kayan Inti',
                    lat: 24.469320,
                    lng: 39.612040
                }
            },
            private: {
                mekkah: {
                    name: 'Le Meridien',
                    lat: 21.420627230335835,
                    lng: 39.829335886507536
                },
                madinah: {
                    name: 'Al Ritz Madinah',
                    lat: 24.473468132939043,
                    lng: 39.610490615343394
                }
            },
        };

        document.getElementById('jenis_paket').addEventListener('change', function() {
            const selected = this.value;

            if (!hotelData[selected]) return;

            document.getElementById('hotel_mekkah').value = hotelData[selected].mekkah.name;
            document.getElementById('hotel_madinah').value = hotelData[selected].madinah.name;

            document.getElementById('lat_mekkah').value = hotelData[selected].mekkah.lat;
            document.getElementById('lng_mekkah').value = hotelData[selected].mekkah.lng;
            document.getElementById('lat_madinah').value = hotelData[selected].madinah.lat;
            document.getElementById('lng_madinah').value = hotelData[selected].madinah.lng;
        });
    </script>

    <script>
        const hargaInput = document.getElementById('harga');

        hargaInput.addEventListener('keyup', function(e) {
            let value = this.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            this.value = 'Rp ' + rupiah;
        });
    </script>
</body>

</html>