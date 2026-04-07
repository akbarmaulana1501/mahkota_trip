<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Haji & Umroh</title>
    <link rel="icon" href="{{asset('template/assets/dist/img/logo_mahkota.png')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1a1a1a;
            --accent: #FFA500;
            --dark: #0f172a;
            --light: #f8fafc;
            --text: #1e293b;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: var(--light);
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #F5A623, #D97706);
        }

        .gradient-dark {
            background: linear-gradient(135deg, #0F0F0F, #1A1A1A);
        }

        .booked-date {
            background: #dc2626 !important;
            color: white !important;
            border-radius: 6px;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

    <!-- Booking Page Container -->
    <div id="booking-page" class="hidden">
        <div class="min-h-screen pt-20 pb-12 px-4 sm:px-6 lg:px-8 gradient-dark">
            <div class="max-w-3xl mx-auto">
                <!-- Back Button -->
                <button onclick="goBack()" class="mb-8 flex items-center gap-2 text-orange-500 hover:text-orange-400 font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </button>

                <!-- Form Header with Progress -->
                <div class="bg-slate-800 rounded-2xl shadow-2xl p-8 md:p-12 mb-8">
                    <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-6">Pendaftaran Jamaah</h1>

                    <!-- Progress Bar -->
                    <div class="flex items-center gap-3">
                        <div id="progress-bar" class="flex-1 h-2 bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 transition-all duration-300"></div>
                        </div>
                        <span id="step-counter" class="text-orange-500 font-semibold text-lg">1 / 6</span>
                    </div>

                    <p id="step-title" class="text-2xl font-bold text-orange-500 mt-4">A. Data Pribadi</p>
                    <p id="step-description" class="text-lg text-slate-300 mt-2">Isi informasi pribadi Anda</p>
                </div>

                <div class="bg-slate-800 rounded-2xl shadow-xl p-6 mb-6">
                    <h2 class="text-white text-2xl font-bold mb-3">Paket Dipilih</h2>

                    <p id="paket-terpilih" class="text-orange-500 text-lg font-semibold">
                        Belum memilih paket
                    </p>
                </div>


                <div id="umroh_private" style="display: none;">
                    <div class="bg-slate-800 rounded-2xl shadow-xl p-6 mb-6 max-w-md mx-auto">
                        <h2 class="text-white text-xl font-bold mb-4 text-center">Tetapkan Tanggal Keberangkatan</h2>

                        <div class="flex flex-col gap-4">
                            <input type="date" name="tanggal_umroh_private" id="tanggal_umroh_private"
                                class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">

                            <!-- <button
                                class="w-full px-6 py-3 bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg transition-all transform hover:scale-[1.02] shadow-lg">
                                Simpan Tanggal
                            </button> -->
                        </div>
                    </div>
                </div>


                @if (session('success'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Success!",
                        text: "Anda Berhasil mendaftar Haji,admin akan mengubungi anda melalui WA 1x24 jam.",
                        showConfirmButton: true,
                    });
                </script>
                @endif
                @if (session('success_komentar'))
                <script>
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Terima Kasih!",
                        text: "Terima kasih atas komentar dan rating Anda!",
                        showConfirmButton: true,
                    });
                </script>
                @endif

                <!-- Form -->
                <form id="bookingForm" action="{{ route('jamaah.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-800 rounded-2xl shadow-2xl p-8 md:p-12 space-y-6">
                    @csrf
                    <!-- STEP 1: Data Pribadi -->
                    <input type="hidden" id="id-paket" name="id_paket">
                    <input type="hidden" id="paket-terpilih2" name="paket_terpilih2">
                    <input type="hidden" id="paket-harga" name="paket_harga">
                    <input type="hidden" id="paket-tanggal" name="tgl_berangkat">
                    <div id="step-1" class="step-form space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nama Depan <span class="text-red-400">*</span></label>
                                <input type="text" name="nama_depan" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors" placeholder="Nama Depan">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nama Belakang <span class="text-red-400">*</span></label>
                                <input type="text" name="nama_belakang" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors" placeholder="Nama Belakang">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nama Ayah <span class="text-red-400">*</span></label>
                                <input type="text" name="nama_ayah" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors" placeholder="Nama Belakang">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Jenis Kelamin <span class="text-red-400">*</span></label>
                                <select name="jenis_kelamin" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Tanggal Lahir <span class="text-red-400">*</span></label>
                                <input type="date" name="tanggal_lahir" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Tempat Lahir <span class="text-red-400">*</span></label>
                                <input type="text" name="tempat_lahir" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors" placeholder="masukan alamat">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Status Pernikahan <span class="text-red-400">*</span></label>
                                <select name="status_pernikahan" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                                    <option value="">Pilih Status</option>
                                    <option value="0">Belum Menikah</option>
                                    <option value="1">Menikah</option>
                                    <option value="2">Janda / Duda</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Pekerjaan<span class="text-red-400">*</span></label>
                                <select name="pekerjaan" id="pekerjaan" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach($pekerjaan as $p)
                                    <option value="{{ $p->nama_pekerjaan }}">{{ $p->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Pendidikan<span class="text-red-400">*</span></label>
                                <select name="pendidikan" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                                    <option value="" disabled selected>-- Pilih pendidikan --</option>
                                    <option value="1">SD</option>
                                    <option value="2">SMP</option>
                                    <option value="3">SMA</option>
                                    <option value="4">D4/S1</option>
                                    <option value="5">S2</option>
                                    <option value="6">S3</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Email (opsional)</label>
                                <input type="email" name="email" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors" placeholder="email@example.com">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Alamat Lengkap<span class="text-red-400">*</span></label>
                                <textarea name="alamat_lengkap" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors" rows="2"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">No Telepon <span class="text-red-400">*</span></label>
                                <input type="text" name="kontak_darurat_nama" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">No Telepon Darurat <span class="text-red-400">*</span></label>
                                <input type="tel" name="kontak_darurat_hp" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Dokumen Identitas -->
                    <div id="step-2" class="step-form space-y-6 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Apakah Bapak/Ibu sudah memiliki Passport?</label>
                                <select name="status_passport" id="status_passport" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                                    <option value="">pilih status</option>
                                    <option value="sudah">Sudah</option>
                                    <option value="belum">Belum</option>
                                </select>
                            </div>
                        </div>
                        <div id="berkas_passport_belum" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nomor KTP</label>
                                <input type="text" name="no_ktp"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Foto KTP</label>
                                <input type="file" name="foto_ktp" accept="image/*"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors file:text-amber-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Foto KK</label>
                                <input type="file" name="foto_kk" accept="image/*"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors file:text-amber-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Akte Kelahiran/Buku Nikah/Ijazah</label>
                                <input type="file" name="foto_nikah" accept="image/*,.pdf"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors file:text-amber-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>
                        </div>
                        <div id="berkas_passport_sudah" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nomor KTP</label>
                                <input type="text" name="no_ktp"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Foto KTP</label>
                                <input type="file" name="foto_ktp_sudah" accept="image/*"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors file:text-amber-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Foto KK</label>
                                <input type="file" name="foto_kk_sudah" accept="image/*"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors file:text-amber-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Foto Passport (halaman 4 bagian data diri)</label>
                                <input type="file" name="foto_paspor_sudah" accept="image/*,.pdf"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors file:text-amber-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nomor Passport</label>
                                <input type="text" name="no_passport"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                            </div>
                        </div>
                    </div>
                    <script>
                        document.getElementById("status_passport").addEventListener("change", function() {
                            const val = this.value;
                            const berkas_passport = document.getElementById("berkas_passport");

                            if (val === "sudah") {
                                document.getElementById('berkas_passport_belum').classList.add("hidden");
                                document.getElementById('berkas_passport_sudah').classList.remove("hidden");
                            } else if (val === "belum") {
                                document.getElementById('berkas_passport_belum').classList.remove("hidden");
                                document.getElementById('berkas_passport_sudah').classList.add("hidden");
                            }
                        });
                    </script>

                    <!-- STEP 3: Data Kesehatan -->
                    <div id="step-3" class="step-form space-y-6 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Apakah Bapak/Ibu sudah melakukan Vaksi Meningitis?</label>
                                <select name="status_vaksin_meningitis" id="status_vaksin_meningitis" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                                    <option value="">Pilih Status</option>
                                    <option value="sudah">Sudah</option>
                                    <option value="belum">Belum</option>
                                </select>
                            </div>
                            <!-- <div id="sudah_vaksin" style="display: none;">
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Tangal Vaksin</label>
                                <input type="date" name="tgl_vaksin" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                            </div> -->
                        </div>
                    </div>
                    <!-- <script>
                        document.getElementById("status_vaksin_meningitis").addEventListener("change", function() {
                            const val = this.value;
                            const sudahVaksin = document.getElementById("sudah_vaksin");

                            if (val === "sudah") {
                                sudahVaksin.style.display = "block";
                            } else {
                                sudahVaksin.style.display = "none";
                            }
                        });
                    </script> -->


                    <!-- STEP 4: Pembayaran -->
                    <div id="step-4" class="step-form space-y-6 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Informasi Rekening -->
                            <div class="bg-slate-700 p-5 rounded-xl border border-slate-600 text-slate-200 shadow">
                                <img src="{{ asset('template/assets/dist/img/bsi.png') }}" alt="BSI">
                                <h4 class="text-lg font-bold mb-3 text-amber-400">Informasi Pembayaran</h4>
                                <p><span class="font-semibold text-slate-300">Bank:</span> Bank Syariah Indonesia (BSI)</p>
                                <p><span class="font-semibold text-slate-300">Atas Nama:</span> PT. Mansyur Amanah Travel</p>
                                <p><span class="font-semibold text-slate-300">No Rekening:</span> 6667777718</p>
                            </div>

                            <!-- Upload Bukti DP -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Bukti Bayar DP</label>
                                <input
                                    type="file"
                                    name="bukti_bayar_dp"
                                    id="bukti_bayar_dp_input"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600
                       focus:border-amber-400 focus:outline-none transition-colors
                       file:text-amber-400 file:bg-slate-600 file:rounded file:px-3 file:py-1"
                                    accept="image/*,.pdf"
                                    required>
                                <p class="text-xs text-slate-400 mt-2">
                                    Format yang diperbolehkan: JPG, PNG, PDF (max 5MB)
                                </p>
                                <div class="mt-3">
                                    <label class="block text-sm font-semibold text-slate-200 mb-2">Nominal</label>
                                    <input
                                        type="text"
                                        id="nominal_output" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600
                       focus:border-amber-400 focus:outline-none transition-colors
                       file:text-amber-400 file:bg-slate-600 file:rounded file:px-3 file:py-1"
                                        readonly>
                                    <input type="hidden" id="nominal_ouptut2" name="nominal">
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Navigation buttons at the bottom -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-slate-700">
                        <button type="button" id="btn-prev" onclick="prevStep()" class="flex-1 px-6 py-3 bg-slate-600 hover:bg-slate-700 text-white font-semibold rounded-lg transition-colors transform hover:scale-105 hidden">
                            ← Sebelumnya
                        </button>
                        <button type="button" id="btn-cancel" onclick="goBack()" class="flex-1 px-6 py-3 bg-slate-600 hover:bg-slate-700 text-white font-semibold rounded-lg transition-colors transform hover:scale-105">
                            Batal
                        </button>
                        <button type="button" id="btn-next" onclick="nextStep()" class="flex-1 px-6 py-3 gradient-primary hover:shadow-lg text-white font-semibold rounded-lg transition-all transform hover:scale-105">
                            Selanjutnya →
                        </button>
                        <button type="submit" id="btn-submit" class="flex-1 px-6 py-3 gradient-primary hover:shadow-lg text-white font-semibold rounded-lg transition-all transform hover:scale-105 hidden">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Page with Navigation to Booking Page -->
    <div id="main-page">
        <!-- Header Navigation -->
        <header class="fixed w-full top-0 z-50 bg-slate-950/90 backdrop-blur border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg gradient-primary flex items-center justify-center">
                            <img src="{{ asset('template/assets/dist/img/logo_mahkota.png') }}" alt="Logo Mahkota">
                        </div>
                        <span class="font-display text-xl font-bold text-slate-200">MAHKOTA TRIP</span>
                    </div>

                    <!-- MENU DESKTOP -->
                    <nav class="hidden md:flex items-center gap-8">
                        <a href="#home" class="text-slate-300 hover:text-amber-400">Home</a>
                        <a href="#paket" class="text-slate-300 hover:text-amber-400">Paket</a>
                        <a href="#kontak" class="text-slate-300 hover:text-amber-400">Kontak</a>
                        <a href="/login" class="px-6 py-3 border-2 border-amber-400 text-amber-300 hover:bg-amber-500/10 font-semibold rounded-lg transition-all">Login</a>
                    </nav>

                    <!-- BUTTON MOBILE -->
                    <button id="menuBtn" class="md:hidden text-slate-200 text-2xl">
                        ☰
                    </button>
                </div>

                <!-- MENU MOBILE DROPDOWN -->
                <div id="mobileMenu" class="md:hidden hidden flex-col gap-2 py-4 border-t border-slate-800">
                    <a href="#home"
                        class="group block px-4 py-2 rounded-lg text-slate-300 transition-all
              hover:bg-slate-800 hover:text-amber-400">
                        Home
                    </a>

                    <a href="#paket"
                        class="group block px-4 py-2 rounded-lg text-slate-300 transition-all
              hover:bg-slate-800 hover:text-amber-400">
                        Paket
                    </a>

                    <a href="#kontak"
                        class="group block px-4 py-2 rounded-lg text-slate-300 transition-all
              hover:bg-slate-800 hover:text-amber-400">
                        Kontak
                    </a>
                </div>

            </div>
        </header>


        <!-- Hero Section -->
        <section id="home" class="pt-20 min-h-screen flex items-center justify-center gradient-dark relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-20 left-10 w-72 h-72 bg-amber-400 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-yellow-300 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-block mb-6 px-4 py-2 bg-white border border-amber-400/40 rounded-full">
                    <img src="{{ asset('template/assets/dist/img/logo_mahkota.png') }}" alt="Logo Mahkota" class="w-24 h-24 object-contain">
                </div>
                <h1 class="font-display text-5xl md:text-5xl font-bold text-white mb-6">
                    Wujudkan Ibadah <span class="text-amber-400">Umroh & Haji</span> Impian Anda
                </h1>
                <p class="text-xl md:text-2xl text-slate-200 mb-8 leading-relaxed max-w-2xl mx-auto">
                    Kami menyediakan layanan profesional dan terpercaya untuk perjalanan Anda ke Tanah Suci dengan harga kompetitif.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#paket" class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-slate-900 font-semibold rounded-lg transition-all transform hover:scale-105 shadow-lg">
                        Pesan Sekarang →
                    </a>
                    <a href="#testimoni" class="px-8 py-4 border-2 border-amber-400 text-amber-300 hover:bg-amber-500/10 font-semibold rounded-lg transition-all">
                        Lihat Testimoni
                    </a>
                </div>
            </div>
        </section>

        <!-- Why Us Section -->
        <section class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="font-display text-4xl md:text-5xl font-bold text-slate-900 mb-4">Mengapa Memilih Kami?</h2>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">Pengalaman bertahun-tahun melayani ribuan jemaah dengan dedikasi penuh</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="group p-8 rounded-2xl border-2 border-slate-100 hover:border-amber-400 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 rounded-lg gradient-primary flex items-center justify-center text-white text-2xl mb-4 group-hover:scale-110 transition-transform">
                            ✓
                        </div>
                        <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Terpercaya & Berpengalaman</h3>
                        <p class="text-slate-600">Ribuan jemaah telah dipercayakan kepada kami dengan tingkat kepuasan 99%</p>
                    </div>
                    <div class="group p-8 rounded-2xl border-2 border-slate-100 hover:border-amber-400 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 rounded-lg gradient-primary flex items-center justify-center text-white text-2xl mb-4 group-hover:scale-110 transition-transform">
                            💎
                        </div>
                        <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Hotel & Fasilitas Premium</h3>
                        <p class="text-slate-600">Penginapan bintang 5 pilihan dengan lokasi strategis dekat Masjidil Haram</p>
                    </div>
                    <div class="group p-8 rounded-2xl border-2 border-slate-100 hover:border-amber-400 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 rounded-lg gradient-primary flex items-center justify-center text-white text-2xl mb-4 group-hover:scale-110 transition-transform">
                            👥
                        </div>
                        <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Guide Profesional</h3>
                        <p class="text-slate-600">Tim guide berpengalaman siap memandu setiap langkah ibadah Anda</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Paket Section -->
        <section id="paket" class="py-20 bg-slate-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="font-display text-4xl md:text-5xl font-bold text-slate-900 mb-4">Paket Umroh Terbaik</h2>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">Pilihan paket dengan fasilitas lengkap dan harga terbaik di kelasnya</p>
                </div>
                <div class="bg-white rounded-2xl shadow-xl p-6 mb-10 max-w-md mx-auto">
                    <label for="paket_bulan" class="block text-slate-900 text-sm font-semibold mb-2">
                        Pilih Bulan Keberangkatan
                    </label>

                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-amber-400 pointer-events-none"
                            fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                        </svg>

                        <select
                            id="paket_bulan"
                            name="paket_bulan"
                            class="w-full bg-white text-slate-900 rounded-xl pl-12 pr-4 py-3
                   border border-slate-300
                   focus:outline-none focus:ring-2 focus:ring-amber-500
                   focus:border-amber-500 transition">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                </div>

                @php
                $count = $paket->count();
                @endphp

                <div class="@if($count <= 2) flex justify-center gap-8 flex-wrap @else grid grid-cols-1 justify-items-center md:grid-cols-3 gap-8 @endif">
                    @forelse ($paket as $p)

                    @php
                    $isHaji = $p->jenis_paket === 'haji';
                    @endphp

                    <div class="group bg-white text-slate-900 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 duration-300 w-80 paket-card"
                        data-bulan="{{ $p->tgl_berangkat ? \Carbon\Carbon::parse($p->tgl_berangkat)->format('n') : '' }}"
                        data-nama="{{ strtolower($p->nama_paket) }}"
                        data-jenis="{{ strtolower($p->jenis_paket) }}">
                        <!-- GARIS ATAS (SATU-SATUNYA YANG BEDA) -->
                        <div class="h-2 {{ $isHaji ? 'bg-slate-900' : 'bg-amber-500' }}"></div>

                        <!-- ISI CARD (SEMUA SAMA) -->
                        <div class="p-8 text-center">

                            @php
                            $kelas = strtolower($p->jenis_paket);
                            @endphp

                            <div class="inline-block px-3 py-1 rounded-full text-sm font-semibold mb-4
                                @if($kelas === 'gold')
                                    bg-yellow-100 text-yellow-700
                                @elseif($kelas === 'silver')
                                    bg-slate-200 text-slate-700
                                @elseif($kelas === 'bronze')
                                    bg-orange-100 text-orange-700
                                @else
                                    bg-slate-100 text-slate-600
                                @endif
                            ">
                                {{ ucfirst($p->jenis_paket) }}
                            </div>

                            <h3 class="font-display text-2xl font-bold mb-2">
                                {{ $p->nama_paket }}
                            </h3>

                            <p class="text-slate-600 text-sm mb-4">
                                {{ $p->deskripsi ?? '-' }}
                            </p>

                            <p class="text-slate-500 text-sm mb-6">
                                <strong>Tanggal Berangkat:</strong>
                                @if (strtolower($p->jenis_paket) === 'private')
                                <strong>Ditentukan Jamaah</strong>
                                @else
                                {{ $p->tgl_berangkat? \Carbon\Carbon::parse($p->tgl_berangkat)->format('d M Y'): '-' }}
                                @endif
                            </p>

                            <p class="text-slate-500 text-sm mb-6">
                                <strong>Kuota Tersedia:</strong>
                                {{ $p->kuota - $p->jamaah_count }}
                            </p>

                            <div class="mb-6">
                                <span
                                    class="font-display text-4xl font-bold {{ $isHaji ? 'text-black' : 'text-amber-500' }}">
                                    Rp {{ number_format($p->harga_paket, 0, ',', '.') }}
                                </span>
                            </div>

                            <p class="text-slate-500 text-sm mb-6">
                                <strong>Lokasi Hotel:</strong>

                                <a href="https://www.google.com/maps?q=<?= urlencode($p->lokasi_mekkah) ?>" target="_blank"
                                    class="inline-block bg-slate-100 text-slate-600 text-xs font-semibold px-3 py-1 rounded-full mr-2 hover:bg-green-200 transition">
                                    Mekkah
                                </a>

                                <a href="https://www.google.com/maps?q=<?= urlencode($p->lokasi_madinah) ?>" target="_blank"
                                    class="inline-block bg-slate-100 text-slate-600 text-xs font-semibold px-3 py-1 rounded-full hover:bg-blue-200 transition">
                                    Madinah
                                </a>
                            </p>

                            <button
                                class="btn-booking w-full py-3 font-semibold rounded-lg border-2 transition 
                                {{ $isHaji 
                                    ? 'bg-white text-black border-black hover:bg-gray-100' 
                                    : 'bg-white text-amber-600 border-amber-500 hover:bg-amber-50' }}"
                                data-nama="{{ $p->nama_paket }}"
                                data-id="{{ $p->id }}"
                                data-harga="{{ $p->harga_paket }}"
                                data-tanggal="{{ $p->tgl_berangkat }}">
                                Pesan Sekarang
                            </button>

                        </div>
                    </div>

                    @empty
                    <div class="text-center py-20">
                        <div class="inline-flex flex-col items-center gap-4">
                            <div class="text-6xl">📦</div>
                            <h3 class="text-2xl font-bold text-slate-800">
                                Belum Ada Paket Bulan Ini
                            </h3>
                            <p class="text-slate-500">
                                Silakan cek kembali di bulan berikutnya atau hubungi admin.
                            </p>
                        </div>
                    </div>
                    @endforelse
                </div>

            </div>
        </section>

        <!-- Testimonial Section -->
        <section class="py-20 bg-white" id="testimoni">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="font-display text-4xl md:text-5xl font-bold text-slate-900 mb-4">Testimoni Jemaah</h2>
                    <p class="text-lg text-slate-600">Kepuasan pelanggan adalah prioritas utama kami</p>
                </div>

                @php
                // Hanya komentar dengan status = 1
                $activePesans = $pesans->where('status', 1);
                $colClass = count($activePesans) === 1 ? 'md:grid-cols-1 justify-items-center' : 'md:grid-cols-3';
                @endphp

                <div class="grid {{ $colClass }} gap-8">
                    @forelse ($activePesans as $pesan)
                    <div class="p-6 rounded-xl bg-slate-50 border border-slate-200 w-full md:w-auto">
                        <div class="flex gap-1 mb-4 justify-center">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <=$pesan->rating)
                                <span class="text-amber-400 text-lg">★</span>
                                @else
                                <span class="text-gray-300 text-lg">★</span>
                                @endif
                                @endfor
                        </div>

                        <p class="text-slate-700 mb-4 italic text-center">"{{ $pesan->pesan }}"</p>

                        <p class="font-semibold text-slate-900 text-center">{{ $pesan->nama }}</p>
                        <p class="text-sm text-slate-600 text-center">{{ $pesan->created_at->format('d M Y') }}</p>
                    </div>
                    @empty
                    <div class="col-span-3 p-6 rounded-xl bg-slate-50 border border-slate-200 text-center text-slate-700">
                        Belum ada komentar
                    </div>
                    @endforelse
                </div>
            </div>
        </section>


        <!-- Contact Section -->
        <section id="kontak" class="py-20 gradient-dark relative overflow-hidden">
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-20 left-20 w-96 h-96 bg-emerald-400 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">Pesan & Kesan Jamaah</h2>
                    <p class="text-xl text-slate-300">Berikan pesan & kesan anda setelah melakukan perjalan bersama kami</p>
                </div>

                <div class="bg-slate-900 rounded-2xl shadow-2xl border border-slate-800 p-8 md:p-10">
                    <form action="{{ route('pesan.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="flex items-center justify-center gap-4 mb-4">
                            <span class="text-white text-lg font-semibold">Nilai Kami:</span>
                            <div class="flex space-x-2" id="rating">
                                <span class="star cursor-pointer text-gray-400 text-5xl">★</span>
                                <span class="star cursor-pointer text-gray-400 text-5xl">★</span>
                                <span class="star cursor-pointer text-gray-400 text-5xl">★</span>
                                <span class="star cursor-pointer text-gray-400 text-5xl">★</span>
                                <span class="star cursor-pointer text-gray-400 text-5xl">★</span>
                            </div>
                        </div>

                        <input type="hidden" name="rating" id="rating-value" value="0">

                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" name="nama" placeholder="Nama Lengkap" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                            <input type="email" name="email" placeholder="Email Anda" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors">
                        </div>
                        <textarea name="pesan" placeholder="Pesan Anda" rows="4" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-amber-400 focus:outline-none transition-colors"></textarea>

                        <button type="submit" class="w-full px-6 py-3 gradient-primary text-white font-semibold rounded-lg hover:shadow-lg transition-all transform hover:scale-105">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <script>
                    const stars = document.querySelectorAll("#rating .star");
                    const ratingValue = document.getElementById("rating-value");

                    stars.forEach((star, index) => {
                        star.addEventListener("click", () => {
                            ratingValue.value = index + 1;

                            stars.forEach((s, i) => {
                                if (i <= index) {
                                    s.classList.remove("text-gray-400");
                                    s.classList.add("text-amber-400");
                                } else {
                                    s.classList.remove("text-amber-400");
                                    s.classList.add("text-gray-400");
                                }
                            });
                        });
                    });
                </script>


            </div>
        </section>

        <!-- Footer -->
        <footer class="gradient-dark border-t border-slate-700 py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-slate-400">© 2025 Mahkota Trip - Semua Hak Dilindungi. Layanan Terpercaya untuk Ibadah Anda.</p>
                    <div class="flex gap-6 mt-4 md:mt-0">
                        <a href="#" class="text-slate-400 hover:text-amber-400 transition-colors">Privacy Policy</a>
                        <a href="#" class="text-slate-400 hover:text-amber-400 transition-colors">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- JavaScript functions to handle page navigation -->
    @include('layouts.script')
    <script>
        let currentStep = 1;
        const totalSteps = 4;

        const stepTitles = [
            "A. Data Pribadi",
            "B. Passport",
            "C. Vaksinasi",
            "D. Pembayaran"
        ];

        const stepDescriptions = [
            "Isi informasi pribadi Anda",
            "Data Passport",
            "Cek Vaksinasi",
            "Selesaikan Pembayaran"
        ];

        function updateStep() {
            document.querySelectorAll('.step-form').forEach(form => {
                form.classList.add('hidden');
            });

            document.getElementById(`step-${currentStep}`).classList.remove('hidden');

            const progress = (currentStep / totalSteps) * 100;
            document.querySelector('#progress-bar > div').style.width = progress + '%';

            document.getElementById('step-counter').textContent = `${currentStep} / ${totalSteps}`;

            document.getElementById('step-title').textContent = stepTitles[currentStep - 1];
            document.getElementById('step-description').textContent = stepDescriptions[currentStep - 1];

            const btnPrev = document.getElementById('btn-prev');
            const btnNext = document.getElementById('btn-next');
            const btnSubmit = document.getElementById('btn-submit');
            const btnCancel = document.getElementById('btn-cancel');

            if (currentStep === 1) {
                btnPrev.classList.add('hidden');
            } else {
                btnPrev.classList.remove('hidden');
            }

            if (currentStep === totalSteps) {
                btnNext.classList.add('hidden');
                btnSubmit.classList.remove('hidden');
            } else {
                btnNext.classList.remove('hidden');
                btnSubmit.classList.add('hidden');
            }

            window.scrollTo(0, 0);
        }

        function nextStep() {
            const result = validateStep(currentStep);
            if (result === true) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateStep();
                }
            } else if (result === "belum_vaksin") {
                Swal.fire({
                    title: "Perhatian!",
                    text: "Anda belum vaksin meningitis. Harap melakukan vaksin sebelum keberangkatan!",
                    icon: "warning"
                });
                return;
            } else {
                Swal.fire({
                    title: "Kesalahan!",
                    text: "Mohon isi semua field yang diperlukan pada bagian ini!",
                    icon: "error"
                });
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateStep();
            }
        }

        function validateStep(step) {
            console.log(step)
            const form = document.getElementById(`step-${step}`);

            const requiredInputs = form.querySelectorAll('[required]');
            for (let input of requiredInputs) {
                if (!input.value.trim()) {
                    input.focus();
                    return false;
                }
            }

            return true;
        }

        document.querySelectorAll('.btn-booking').forEach(btn => {
            btn.addEventListener('click', function() {
                showBooking(
                    this.dataset.id,
                    this.dataset.nama,
                    this.dataset.harga,
                    this.dataset.tanggal
                );
            });
        });

        function showBooking(id = null, namaPaket = null, harga = null, tanggal = null) {

            document.getElementById('main-page')?.classList.add('hidden');
            document.getElementById('booking-page')?.classList.remove('hidden');

            if (namaPaket && harga) {

                document.getElementById('paket-terpilih').innerText =
                    `${namaPaket} - Rp ${Number(harga).toLocaleString('id-ID')}`;

                document.getElementById('id-paket').value = id;
                document.getElementById('paket-terpilih2').value = namaPaket;
                document.getElementById('paket-harga').value = harga;
                document.getElementById('paket-tanggal').value = tanggal ?? '';
            }

            const privateBox = document.getElementById('umroh_private');

            if (namaPaket && namaPaket.toLowerCase() === 'umroh private') {
                privateBox.style.display = 'block';
            } else {
                privateBox.style.display = 'none';
            }

            currentStep = 1;
            updateStep();
        }


        function goBack() {
            document.getElementById('booking-page').classList.add('hidden');
            document.getElementById('main-page').classList.remove('hidden');
            window.scrollTo(0, 0);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('bukti_bayar_dp_input');
            const nominalOutput = document.getElementById('nominal_output');
            const nominalOutput2 = document.getElementById('nominal_ouptut2');

            function cleanAndFormatNominal(text) {
                const nominalRegex = /Rp\s*([\d.,]+)/gi;
                let matches = Array.from(text.matchAll(nominalRegex));

                if (matches.length === 0) return 'Nominal tidak ditemukan.';

                let highestValue = 0;
                for (const match of matches) {
                    let numStr = match[1].replace(/\./g, '').replace(/,/g, '.');
                    let value = parseFloat(numStr);
                    if (!isNaN(value) && value > highestValue) highestValue = value;
                }

                return `Rp ${highestValue.toLocaleString('id-ID')}`;
            }

            function cleanAndGetNumber(text) {
                const nominalRegex = /Rp\s*([\d.,]+)/gi;
                let matches = Array.from(text.matchAll(nominalRegex));

                if (matches.length === 0) return null;

                let highestValue = 0;
                for (const match of matches) {
                    let numStr = match[1].replace(/\./g, '').replace(/,/g, '.');
                    let value = parseFloat(numStr);
                    if (!isNaN(value) && value > highestValue) highestValue = value;
                }

                return highestValue;
            }

            async function runOCR(imageFile) {
                Swal.fire({
                    title: 'Memproses OCR...',
                    text: 'Tunggu sebentar, ini bisa memakan beberapa detik.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                nominalOutput.value = '';
                nominalOutput.style.backgroundColor = 'yellow';

                const worker = await Tesseract.createWorker();

                await worker.loadLanguage('eng+ind');
                await worker.initialize('eng+ind');

                await worker.setParameters({
                    tessedit_char_whitelist: '0123456789.,Rp'
                });

                const {
                    data: {
                        text
                    }
                } = await worker.recognize(imageFile);
                await worker.terminate();

                const detectedNominal = cleanAndFormatNominal(text);
                const detectedNominal2 = cleanAndGetNumber(text);

                nominalOutput.value = detectedNominal;
                nominalOutput2.value = detectedNominal2;
                nominalOutput.style.backgroundColor = detectedNominal.includes('Nominal') ? '#dc2626' : '#10b981';

                Swal.close();

                Swal.fire({
                    icon: detectedNominal.includes('Nominal') ? 'error' : 'success',
                    title: 'OCR Selesai',
                    html: `Nominal Dideteksi: <b>${detectedNominal}</b>`,
                });
            }

            fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) runOCR(file);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectBulan = document.getElementById('paket_bulan');
            const bulanSekarang = new Date().getMonth() + 1;
            selectBulan.value = bulanSekarang;
        });
    </script>
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    <script>
        document.getElementById('paket_bulan').addEventListener('change', function() {
            const selectedMonth = this.value;
            const cards = document.querySelectorAll('.paket-card');

            cards.forEach(card => {
                const bulan = card.dataset.bulan;
                const nama = card.dataset.nama;
                const jenis = card.dataset.jenis;

                // Paket yang tidak boleh ikut filter
                const isExcluded = jenis === 'haji' || nama.includes('private');

                if (isExcluded) {
                    card.style.display = 'block';
                    return;
                }

                // Paket Umroh Gold / Silver / Bronze
                if (bulan === selectedMonth) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        flatpickr("#tanggal_umroh_private", {
            dateFormat: "Y-m-d",
            minDate: "today",
            disable: bookedDates,
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                const date = dayElem.dateObj.toISOString().split('T')[0];
                if (bookedDates.includes(date)) {
                    dayElem.classList.add("booked-date");
                }
            }
        });
    </script>



</body>

</html>