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
            --primary: #10b981;
            --accent: #d4af37;
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
            background: linear-gradient(135deg, var(--primary) 0%, #059669 100%);
        }

        .gradient-dark {
            background: linear-gradient(135deg, var(--dark) 0%, #1e293b 100%);
        }
    </style>
</head>

<body>

    <!-- Booking Page Container -->
    <div id="booking-page" class="hidden">
        <div class="min-h-screen pt-20 pb-12 px-4 sm:px-6 lg:px-8 gradient-dark">
            <div class="max-w-3xl mx-auto">
                <!-- Back Button -->
                <button onclick="goBack()" class="mb-8 flex items-center gap-2 text-emerald-400 hover:text-emerald-300 font-semibold transition-colors">
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
                            <div class="h-full bg-emerald-500 transition-all duration-300" style="width: 16.67%"></div>
                        </div>
                        <span id="step-counter" class="text-emerald-400 font-semibold text-lg">1 / 6</span>
                    </div>

                    <p id="step-title" class="text-2xl font-bold text-emerald-400 mt-4">A. Data Pribadi</p>
                    <p id="step-description" class="text-lg text-slate-300 mt-2">Isi informasi pribadi Anda</p>
                </div>

                <div class="bg-slate-800 rounded-2xl shadow-xl p-6 mb-6">
                    <h2 class="text-white text-2xl font-bold mb-3">Paket Dipilih</h2>

                    <p id="paket-terpilih" class="text-emerald-400 text-lg font-semibold">
                        Belum memilih paket
                    </p>
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
                                <input type="text" name="nama_depan" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" placeholder="Nama Depan">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nama Belakang <span class="text-red-400">*</span></label>
                                <input type="text" name="nama_belakang" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" placeholder="Nama Belakang">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Jenis Kelamin <span class="text-red-400">*</span></label>
                                <select name="jenis_kelamin" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Tanggal Lahir <span class="text-red-400">*</span></label>
                                <input type="date" name="tanggal_lahir" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            </div>
                            <!-- <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Kebangsaan <span class="text-red-400">*</span></label>
                                <input type="text" name="kebangsaan" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" placeholder="Kebangsaan">
                            </div> -->
                            <!-- <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nomor Passport</label>
                                <input type="text" name="no_passport" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" placeholder="Nomor passport">
                                <p class="text-xs text-yellow-400 mt-1">
                                    Jika belum memiliki passport, bisa dikosongkan saja.
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Tanggal Berlaku Passport</label>
                                <input type="date" name="tgl_passport" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" placeholder="Tanggal berlaku passport">
                                <p class="text-xs text-yellow-400 mt-1">
                                    Jika belum memiliki passport, bisa dikosongkan saja.
                                </p>
                            </div> -->
                            <!-- <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">No HP <span class="text-red-400">*</span></label>
                                <input type="tel" name="no_hp" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" placeholder="08xxxxxxxxxx">
                            </div> -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Email (opsional)</label>
                                <input type="email" name="email" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" placeholder="email@example.com">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" rows="2"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">No Telepon </label>
                                <input type="text" name="kontak_darurat_nama" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">No Telepon Darurat</label>
                                <input type="tel" name="kontak_darurat_hp" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Kontak -->
                    <!-- <div id="#" class="step-form space-y-6 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">No HP <span class="text-red-400">*</span></label>
                                <input type="tel" name="no_hp" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Email (opsional)</label>
                                <input type="email" name="email" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" placeholder="email@example.com">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" rows="2"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Kontak Darurat - Nama</label>
                                <input type="text" name="kontak_darurat_nama" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Kontak Darurat - Nomor HP</label>
                                <input type="tel" name="kontak_darurat_hp" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            </div>
                        </div>
                    </div> -->

                    <!-- STEP 3: Dokumen Identitas -->
                    <div id="step-2" class="step-form space-y-6 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Apakah Bapak/Ibu sudah memiliki Passport?</label>
                                <select name="status_passport" id="status_passport" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
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
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Foto KTP</label>
                                <input type="file" name="foto_ktp" accept="image/*"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors file:text-emerald-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nomor KK</label>
                                <input type="text" name="no_kk"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Foto KK</label>
                                <input type="file" name="foto_kk" accept="image/*"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors file:text-emerald-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Akte Kelahiran/Buku Nikah/Ijazah</label>
                                <input type="file" name="foto_nikah" accept="image/*,.pdf"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors file:text-emerald-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>
                        </div>
                        <div id="berkas_passport_sudah" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                            <!-- <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nomor KTP</label>
                                <input type="text" name="no_ktp"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            </div> -->

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Foto KTP</label>
                                <input type="file" name="foto_ktp_sudah" accept="image/*"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors file:text-emerald-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>

                            <!-- <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Nomor KK</label>
                                <input type="text" name="no_kk"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            </div> -->

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Foto KK</label>
                                <input type="file" name="foto_kk_sudah" accept="image/*"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors file:text-emerald-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Upload Foto Passport (halaman 4 bagian data diri)</label>
                                <input type="file" name="foto_paspor_sudah" accept="image/*,.pdf"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors file:text-emerald-400 file:bg-slate-600 file:rounded file:px-3 file:py-1">
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

                    <!-- STEP 4: Data Kesehatan -->
                    <div id="step-3" class="step-form space-y-6 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Apakah Bapak/Ibu sudah melakukan Vaksi Meningitis?</label>
                                <select name="status_vaksin_meningitis" id="status_vaksin_meningitis" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                                    <option value="">Pilih Status</option>
                                    <option value="sudah">Sudah</option>
                                    <option value="belum">Belum</option>
                                </select>
                            </div>
                            <div id="sudah_vaksin" style="display: none;">
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Tangal Vaksin</label>
                                <input type="date" name="tgl_vaksin" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            </div>
                        </div>
                    </div>
                    <script>
                        document.getElementById("status_vaksin_meningitis").addEventListener("change", function() {
                            const val = this.value;
                            const sudahVaksin = document.getElementById("sudah_vaksin");

                            if (val === "sudah") {
                                sudahVaksin.style.display = "block";
                            } else {
                                sudahVaksin.style.display = "none";
                            }
                        });
                    </script>


                    <!-- STEP 5: Paket & Keberangkatan -->
                    <!-- <div id="step-5" class="step-form space-y-6 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Pilih Paket <span class="text-red-400">*</span></label>
                                <select name="paket_id" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors" required>
                                    <option value="">Pilih Paket</option>
                                    <option value="1">Paket Umroh Reguler - 9 Hari (Rp 29.900.000)</option>
                                    <option value="2">Paket Umroh VIP - 12 Hari (Rp 39.500.000)</option>
                                    <option value="3">Paket Haji Khusus - 30 Hari (Rp 120.000.000)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Status Jamaah</label>
                                <select name="status_jamaah" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                                    <option value="daftar">Daftar</option>
                                    <option value="proses_visa">Proses Visa</option>
                                    <option value="lunas">Lunas</option>
                                    <option value="berangkat">Berangkat</option>
                                    <option value="kembali">Kembali</option>
                                </select>
                            </div>
                        </div>
                    </div> -->

                    <!-- STEP 6: Pembayaran -->
                    <div id="step-4" class="step-form space-y-6 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Informasi Rekening -->
                            <div class="bg-slate-700 p-5 rounded-xl border border-slate-600 text-slate-200 shadow">
                                <img src="{{ asset('template/assets/dist/img/bsi.png') }}" alt="BSI">
                                <h4 class="text-lg font-bold mb-3 text-emerald-400">Informasi Pembayaran</h4>
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
                       focus:border-emerald-400 focus:outline-none transition-colors
                       file:text-emerald-400 file:bg-slate-600 file:rounded file:px-3 file:py-1"
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
                       focus:border-emerald-400 focus:outline-none transition-colors
                       file:text-emerald-400 file:bg-slate-600 file:rounded file:px-3 file:py-1"
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
        <header class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg gradient-primary flex items-center justify-center text-white font-bold font-display text-lg">
                            <img src="{{ asset('template/assets/dist/img/logo_mahkota.png') }}" alt="Logo Mahkota">
                        </div>
                        <span class="font-display text-xl font-bold text-slate-900">MAHKOTA TRIP</span>
                    </div>
                    <nav class="hidden md:flex items-center gap-8">
                        <a href="#home" class="text-slate-600 hover:text-slate-900 font-medium transition-colors py-1">
                            Home
                        </a>
                        <a href="#paket" class="text-slate-600 hover:text-slate-900 font-medium transition-colors py-1">
                            Paket
                        </a>
                        <a href="#kontak" class="text-slate-600 hover:text-slate-900 font-medium transition-colors py-1">
                            Kontak
                        </a>
                        <!-- <a href="{{ route('login') }}"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                            Login
                        </a> -->
                    </nav>
                    <button class="md:hidden text-slate-900">☰</button>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section id="home" class="pt-20 min-h-screen flex items-center justify-center gradient-dark relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-yellow-300 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-block mb-6 px-4 py-2 bg-emerald-500/20 border border-emerald-400/40 rounded-full">
                    <!-- <span class="text-emerald-300 text-sm font-semibold">✨ Pelayanan Terpercaya Sejak 2010</span> -->
                    <img src="{{ asset('template/assets/dist/img/logo_mahkota.png') }}" alt="Logo Mahkota" class="w-24 h-24 object-contain">
                </div>
                <h1 class="font-display text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    Wujudkan Ibadah <span class="text-emerald-400">Umroh & Haji</span> Impian Anda
                </h1>
                <p class="text-xl md:text-2xl text-slate-200 mb-8 leading-relaxed max-w-2xl mx-auto">
                    Kami menyediakan layanan profesional dan terpercaya untuk perjalanan Anda ke Tanah Suci dengan harga kompetitif.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <!-- Modified button to open booking page -->
                    <a href="#paket" class="px-8 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg transition-all transform hover:scale-105 shadow-lg">
                        Pesan Sekarang →
                    </a>
                    <a href="#kontak" class="px-8 py-4 border-2 border-emerald-400 text-emerald-300 hover:bg-emerald-500/10 font-semibold rounded-lg transition-all">
                        Hubungi Kami
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
                    <div class="group p-8 rounded-2xl border-2 border-slate-100 hover:border-emerald-400 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 rounded-lg gradient-primary flex items-center justify-center text-white text-2xl mb-4 group-hover:scale-110 transition-transform">
                            ✓
                        </div>
                        <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Terpercaya & Berpengalaman</h3>
                        <p class="text-slate-600">Ribuan jemaah telah dipercayakan kepada kami dengan tingkat kepuasan 99%</p>
                    </div>
                    <div class="group p-8 rounded-2xl border-2 border-slate-100 hover:border-emerald-400 hover:shadow-xl transition-all">
                        <div class="w-14 h-14 rounded-lg gradient-primary flex items-center justify-center text-white text-2xl mb-4 group-hover:scale-110 transition-transform">
                            💎
                        </div>
                        <h3 class="font-display text-xl font-bold text-slate-900 mb-3">Hotel & Fasilitas Premium</h3>
                        <p class="text-slate-600">Penginapan bintang 5 pilihan dengan lokasi strategis dekat Masjidil Haram</p>
                    </div>
                    <div class="group p-8 rounded-2xl border-2 border-slate-100 hover:border-emerald-400 hover:shadow-xl transition-all">
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
                        <!-- Icon kalender -->
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-emerald-400 pointer-events-none"
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
                   focus:outline-none focus:ring-2 focus:ring-emerald-500
                   focus:border-emerald-500 transition">
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

                <div class="@if($count <= 2) flex justify-center gap-8 flex-wrap @else grid md:grid-cols-3 gap-8 @endif">
                    @forelse ($paket as $p)
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 duration-300 w-80">
                        <div class="h-2 gradient-primary"></div>

                        <div class="p-8 text-center">
                            <!-- Jenis Paket -->
                            <div class="inline-block px-3 py-1 bg-slate-100 rounded-full text-sm font-semibold text-slate-600 mb-4">
                                {{ $p->jenis_paket }}
                            </div>

                            <!-- Nama Paket -->
                            <h3 class="font-display text-2xl font-bold text-slate-900 mb-2">
                                {{ $p->nama_paket }}
                            </h3>

                            <!-- Deskripsi -->
                            <p class="text-slate-600 text-sm mb-4">
                                {{ $p->deskripsi ?? '-' }}
                            </p>

                            <!-- Tanggal Berangkat -->
                            <p class="text-slate-500 text-sm mb-6">
                                <strong>Tanggal Berangkat:</strong>
                                {{ $p->tgl_berangkat
                        ? \Carbon\Carbon::parse($p->tgl_berangkat)->format('d M Y')
                        : '-' }}
                            </p>

                            <p class="text-slate-500 text-sm mb-6">
                                <strong>Kuota Tersedia:</strong>
                                {{ $p->kuota - $p->jamaah_count }}
                            </p>

                            <!-- Harga -->
                            <div class="mb-6">
                                <span class="font-display text-4xl font-bold text-emerald-600">
                                    Rp {{ number_format($p->harga_paket, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Tombol Pesan -->
                            <button
                                class="btn-booking w-full py-3 border-2 border-emerald-500 text-emerald-600 font-semibold rounded-lg"
                                data-nama="{{ $p->nama_paket }}"
                                data-id="{{ $p->id }}"
                                data-harga="{{ $p->harga_paket }}"
                                data-tanggal="{{ $p->tgl_berangkat }}">
                                Pesan Sekarang
                            </button>
                        </div>
                    </div>
                    @empty
                    <!-- Jika tidak ada paket -->
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
        <section class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="font-display text-4xl md:text-5xl font-bold text-slate-900 mb-4">Testimoni Jemaah</h2>
                    <p class="text-lg text-slate-600">Kepuasan pelanggan adalah prioritas utama kami</p>
                </div>

                @php
                $colClass = count($pesans) === 1 ? 'md:grid-cols-1 justify-items-center' : 'md:grid-cols-3';
                @endphp

                <div class="grid {{ $colClass }} gap-8">
                    @forelse ($pesans as $pesan)
                    <div class="p-6 rounded-xl bg-slate-50 border border-slate-200 w-full md:w-auto">
                        <!-- Tampilkan rating bintang -->
                        <div class="flex gap-1 mb-4 justify-center">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <=$pesan->rating)
                                <span class="text-amber-400 text-lg">★</span>
                                @else
                                <span class="text-gray-300 text-lg">★</span>
                                @endif
                                @endfor
                        </div>

                        <!-- Komentar -->
                        <p class="text-slate-700 mb-4 italic text-center">"{{ $pesan->pesan }}"</p>

                        <!-- Nama & info tambahan -->
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

                <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-2xl p-8 md:p-6">
                    <form action="{{route('pesan.store')}}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Rating Bintang Besar di Atas -->
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

                        <!-- Hidden input untuk mengirim nilai rating -->
                        <input type="hidden" name="rating" id="rating-value" value="0">

                        <!-- Form Input -->
                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" name="nama" placeholder="Nama Lengkap" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                            <input type="email" name="email" placeholder="Email Anda" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors">
                        </div>
                        <textarea name="pesan" placeholder="Pesan Anda" rows="4" class="w-full px-4 py-3 rounded-lg bg-slate-700 text-white placeholder-slate-400 border border-slate-600 focus:border-emerald-400 focus:outline-none transition-colors"></textarea>

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
                            ratingValue.value = index + 1; // simpan nilai rating

                            stars.forEach((s, i) => {
                                if (i <= index) {
                                    s.classList.remove("text-gray-400");
                                    s.classList.add("text-amber-400"); // bintang aktif
                                } else {
                                    s.classList.remove("text-amber-400");
                                    s.classList.add("text-gray-400"); // bintang non-aktif
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
                        <a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors">Privacy Policy</a>
                        <a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors">Terms of Service</a>
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
            // "D. Paket & Keberangkatan",
            "D. Pembayaran"
        ];

        const stepDescriptions = [
            "Isi informasi pribadi Anda",
            "Data Passport",
            "Cek Vaksinasi",
            "Selesaikan Pembayaran"
        ];

        function updateStep() {
            // Hide all steps
            document.querySelectorAll('.step-form').forEach(form => {
                form.classList.add('hidden');
            });

            // Show current step
            document.getElementById(`step-${currentStep}`).classList.remove('hidden');

            // Update progress bar
            const progress = (currentStep / totalSteps) * 100;
            document.querySelector('#progress-bar > div').style.width = progress + '%';

            // Update step counter
            document.getElementById('step-counter').textContent = `${currentStep} / ${totalSteps}`;

            // Update titles
            document.getElementById('step-title').textContent = stepTitles[currentStep - 1];
            document.getElementById('step-description').textContent = stepDescriptions[currentStep - 1];

            // Update button visibility
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
                // Semua valid → lanjut
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

            // Validasi default (semua input required)
            const requiredInputs = form.querySelectorAll('[required]');
            for (let input of requiredInputs) {
                if (!input.value.trim()) {
                    input.focus();
                    return false;
                }
            }

            // 🚨 Validasi khusus untuk Step 3
            if (step === 3) {
                const status = document.getElementById("status_vaksin_meningitis").value;

                if (status === "belum") {
                    Swal.fire({
                        title: "Perhatian!",
                        text: "Anda belum vaksin meningitis. Harap melakukan vaksin sebelum keberangkatan!",
                        icon: "warning"
                    });
                    return "belum_vaksin";
                }

                if (status === "sudah") {
                    const date = document.querySelector("input[name='tgl_vaksin']").value;
                    if (!date) {
                        Swal.fire({
                            title: "Kesalahan!",
                            text: "Silakan isi tanggal vaksin!",
                            icon: "error"
                        });
                        return false;
                    }
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

            // pindah halaman
            document.getElementById('main-page')?.classList.add('hidden');
            document.getElementById('booking-page')?.classList.remove('hidden');

            if (namaPaket && harga) {

                // 🔹 TAMPIL DI PANEL "PAKET DIPILIH"
                document.getElementById('paket-terpilih').innerText =
                    `${namaPaket} - Rp ${Number(harga).toLocaleString('id-ID')}`;

                // 🔹 SIMPAN KE INPUT (UNTUK SUBMIT)
                document.getElementById('id-paket').value = id;
                document.getElementById('paket-terpilih2').value = namaPaket;
                document.getElementById('paket-harga').value = harga;
                document.getElementById('paket-tanggal').value = tanggal ?? '';
            }

            // reset step
            currentStep = 1;
            updateStep();
        }

        function goBack() {
            document.getElementById('booking-page').classList.add('hidden');
            document.getElementById('main-page').classList.remove('hidden');
            window.scrollTo(0, 0);
        }

        // Handle form submission
        // document.getElementById('bookingForm').addEventListener('submit', function(e) {
        //     e.preventDefault();

        //     let form = this;
        //     let formData = new FormData(form);

        //     // Ambil CSRF token Laravel
        //     let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        //     // Matikan tombol submit
        //     const submitBtn = document.getElementById('btn-submit');
        //     submitBtn.disabled = true;
        //     submitBtn.innerText = "Mengirim...";

        //     fetch("{{ route('SimpanJamaah') }}", {
        //             method: "POST",
        //             headers: {
        //                 "X-CSRF-TOKEN": csrf
        //             },
        //             body: formData // BUKAN JSON! (karena ada file)
        //         })
        //         .then(async response => {
        //             if (!response.ok) {
        //                 let err = await response.json();
        //                 throw err;
        //             }
        //             return response.json();
        //         })
        //         .then(result => {
        //             console.log("✅ Response:", result);

        //             alert("✅ Pendaftaran berhasil!\n\nKami akan menghubungi Anda untuk konfirmasi.");

        //             // Reset form
        //             form.reset();

        //             // Balik ke step pertama
        //             currentStep = 1;
        //             goBack();

        //             submitBtn.disabled = false;
        //             submitBtn.innerText = "Daftar Sekarang";
        //         })
        //         .catch(error => {
        //             console.error("❌ Error:", error);

        //             // Tampilkan error dari Laravel
        //             if (error.errors) {
        //                 let pesan = "⚠ Form tidak valid:\n\n";
        //                 Object.keys(error.errors).forEach(key => {
        //                     pesan += "• " + error.errors[key][0] + "\n";
        //                 });
        //                 alert(pesan);
        //             } else {
        //                 alert("Terjadi kesalahan saat mengirim data!");
        //             }

        //             submitBtn.disabled = false;
        //             submitBtn.innerText = "Daftar Sekarang";
        //         });
        // });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('bukti_bayar_dp_input');
            const nominalOutput = document.getElementById('nominal_output');
            const nominalOutput2 = document.getElementById('nominal_ouptut2');

            // Fungsi untuk membersihkan dan memformat nominal dari OCR
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

                return highestValue; // angka saja
            }

            // Fungsi utama OCR
            async function runOCR(imageFile) {
                // Tampilkan loading SweetAlert
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

                // console.log("Teks Hasil OCR:", text);

                const detectedNominal = cleanAndFormatNominal(text);
                const detectedNominal2 = cleanAndGetNumber(text);

                // Tampilkan hasil di input
                nominalOutput.value = detectedNominal;
                nominalOutput2.value = detectedNominal2;
                nominalOutput.style.backgroundColor = detectedNominal.includes('Nominal') ? '#dc2626' : '#10b981';

                // Tutup loading SweetAlert
                Swal.close();

                // Bisa juga tampilkan hasil akhir dengan alert
                Swal.fire({
                    icon: detectedNominal.includes('Nominal') ? 'error' : 'success',
                    title: 'OCR Selesai',
                    html: `Nominal Dideteksi: <b>${detectedNominal}</b>`,
                });
            }

            // Event listener input file
            fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) runOCR(file);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectBulan = document.getElementById('paket_bulan');
            const bulanSekarang = new Date().getMonth() + 1; // getMonth() 0-11, tambah 1
            selectBulan.value = bulanSekarang; // set selected
        });
    </script>


</body>

</html>