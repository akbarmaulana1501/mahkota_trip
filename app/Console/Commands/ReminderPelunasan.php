<?php

namespace App\Console\Commands;

use App\Models\Jamaah;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class ReminderPelunasan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reminder-pelunasan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $jamaah = Jamaah::with('pakets')
            ->whereHas('pakets', function ($q) use ($today) {
                $q->whereDate('tgl_berangkat', $today->copy()->addDays(45));
            })
            ->get();

        foreach ($jamaah as $j) {

            // pastikan data aman
            if (!$j->kontak_darurat_nama || !$j->pakets) continue;

            // cek belum lunas DI SINI
            if ($j->nominal >= $j->pakets->harga_paket) continue;

            $noHp =  $j->kontak_darurat_nama;
            $sisa = $j->pakets->harga_paket - $j->nominal;

            $pesan = "Assalamu’alaikum {{ $j->nama_depan . ' ' . $j->nama_belakang }}, 👋\n\n"
                . "Pengingat pelunasan biaya perjalanan.\n"
                . "Keberangkatan: "
                . Carbon::parse($j->pakets->tgl_berangkat)->format('d M Y') . "\n\n"
                . "Sisa pembayaran: Rp " . number_format($sisa, 0, ',', '.') . "\n\n"
                . "Mohon segera diselesaikan. Terima kasih 🙏";

            WhatsAppService::send($noHp, $pesan);
        }

        $this->info('Reminder WA pelunasan berhasil dikirim.');
    }
}
