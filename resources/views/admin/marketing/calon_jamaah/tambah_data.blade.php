<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Tambah Jamaah | Amanah Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{asset('template/assets/dist/img/logo_mahkota.png')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-900">
    <main class="max-w-2xl mx-auto px-4 py-12">
        @if(session('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Success!",
                text: "Pendaftaran Berhasil!",
                showConfirmButton: true,
            });
        </script>
        @endif
        <!-- Welcome Section -->
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-2"> Form Calon Jamaah</h2>
            <p class="text-slate-400">
                Silakan isi formulir di bawah untuk mendaftar sebagai jamaah baru
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 rounded-2xl shadow-lg overflow-hidden border border-slate-700">

            <!-- Form Header -->
            <div class="bg-slate-900 px-8 py-6 border-b border-slate-700">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    Data Calon Jamaah
                </h3>
            </div>

            <!-- Form Body -->
            <form class="p-8 space-y-6" action="{{route('simpanCalonJamaah')}}" method="POST">
                @csrf
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Nama Lengkap</label>
                    <input type="text"
                        class="w-full px-4 py-3 bg-slate-700 text-white border border-slate-600 rounded-lg
                    focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" name="nama_jamaah" id="nama_jamaah">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Jenis Kelamin</label>
                    <select
                        class="w-full px-4 py-3 bg-slate-700 text-white border border-slate-600 rounded-lg
                    focus:outline-none focus:ring-2 focus:ring-emerald-500" name="jenis_kelamin" id="jenis_kelamin">
                        <option>Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <!-- Nomor HP -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Nomor HP</label>
                    <input type="tel"
                        class="w-full px-4 py-3 bg-slate-700 text-white border border-slate-600 rounded-lg
                    focus:outline-none focus:ring-2 focus:ring-emerald-500" name="no_hp" id="no_hp">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">
                        Email <span class="text-slate-500 text-xs">(Opsional)</span>
                    </label>
                    <input type="email"
                        class="w-full px-4 py-3 bg-slate-700 text-white border border-slate-600 rounded-lg
                    focus:outline-none focus:ring-2 focus:ring-emerald-500" name="email" id="email">
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Alamat Lengkap</label>
                    <textarea rows="3"
                        class="w-full px-4 py-3 bg-slate-700 text-white border border-slate-600 rounded-lg
                    focus:outline-none focus:ring-2 focus:ring-emerald-500 resize-none" name="alamat_lengkap" id="alamat_lengkap"></textarea>
                </div>

                <!-- Paket -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Paket Keberangkatan</label>
                    <select
                        class="w-full px-4 py-3 bg-slate-700 text-white border border-slate-600 rounded-lg
                    focus:outline-none focus:ring-2 focus:ring-emerald-500" name="paket_id" id="paket_id">
                        <option value="" disabled selected>Pilih Paket</option>
                        @foreach($paket as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->nama_paket }} - {{ $p->harga_paket }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Referral -->
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Kode Referral</label>
                    <div class="flex gap-2">
                        <input type="text" readonly value="{{$referral}}"
                            class="flex-1 px-4 py-3 bg-slate-600 text-slate-300 border border-slate-600 rounded-lg" name="kode_referral" id="kode_referral">
                    </div>
                </div>

                <!-- Action -->
                <div class="flex gap-3 pt-6 border-t border-slate-700">
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-emerald-600 text-slate-900 rounded-lg font-semibold
                    hover:bg-emerald-700 transition">
                        Daftar
                    </button>
                </div>

            </form>
        </div>

    </main>
</body>

</html>