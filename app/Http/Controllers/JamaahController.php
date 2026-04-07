<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Paket;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Notification;

class JamaahController extends Controller
{
    public function index()
    {
        $jamaah = Jamaah::with('pakets')->where('user_id', auth()->id())->first();
        $paid_total = Payment::where('user_id', $jamaah->id) // filter untuk jamaah login
            ->where('status', 'paid')       // hanya yang sudah bayar
            ->sum('amount');
        return view('jamaah.dashboard', compact('jamaah','paid_total'));
    }

    public function tagihan()
    {
        $jamaah = Jamaah::with('pakets')->where('user_id', auth()->id())->first();
        $payment = Payment::all();
        $paid_total = Payment::where('user_id', $jamaah->id) // filter untuk jamaah login
            ->where('status', 'paid')       // hanya yang sudah bayar
            ->sum('amount');                // jumlahkan kolom amount
        return view('jamaah.tagihan.tampil_data', compact('payment', 'jamaah', 'paid_total'));
    }

    public function dokumen()
    {
        return view('jamaah.dokumen.tampil_data');
    }

    public function jadwal_umroh()
    {
        return view('jamaah.jadwal_umroh.tampil_data');
    }

    public function generateVA(Request $request)
    {
        $user = Auth::guard('jamaah')->user();

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;

        // 🔎 Cek VA Pending
        $existing = Payment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($existing) {

            // ❌ Jika masih aktif → tampilkan
            if ($existing->expired_at > now()) {
                return response()->json([
                    'bank' => $existing->bank,
                    'va' => $existing->va_number,
                    'amount' => number_format($existing->amount),
                    'expired' => $existing->expired_at->format('d M Y H:i')
                ]);
            }

            // ⛔ Jika expired → update gagal
            $existing->update([
                'status' => 'failed'
            ]);
        }

        // 🆕 Buat VA Baru
        $order_id = 'TABUNGAN-' . $user->id . '-' . time();

        $amount = (int) $request->amount;

        $params = [
            "payment_type" => "bank_transfer",
            "transaction_details" => [
                "order_id" => $order_id,
                "gross_amount" => $amount, // <-- gunakan variabel yang sudah di-cast
            ],
            "bank_transfer" => [
                "bank" => "bni"
            ],
            "customer_details" => [
                "first_name" => $user->username,
                "email" => $user->email ?? 'jamaah@email.com',
                "phone" => '08123456789'
            ]
        ];

        $response = \Midtrans\CoreApi::charge($params);

        // 🔐 Ambil VA aman
        $vaNumber = null;

        if (isset($response->va_numbers)) {
            foreach ($response->va_numbers as $va) {
                if ($va->bank == 'bni') {
                    $vaNumber = $va->va_number;
                    break;
                }
            }
        }

        if (!$vaNumber && isset($response->virtual_account)) {
            $vaNumber = $response->virtual_account;
        }

        if (!$vaNumber) {
            return response()->json([
                'message' => 'Gagal membuat VA'
            ], 500);
        }

        // 💾 Simpan
        $payment = Payment::create([
            'user_id' => $user->id,
            'order_id' => $order_id,
            'amount' => $amount,
            'bank' => 'bni',
            'va_number' => $vaNumber,
            'status' => 'pending',
            'expired_at' => now()->addHours(24)
        ]);

        return response()->json([
            'bank' => $payment->bank,
            'va' => $payment->va_number,
            'amount' => number_format($payment->amount),
            'expired' => $payment->expired_at->format('d M Y H:i')
        ]);
    }

    public function cekVA()
    {
        $user = Auth::guard('jamaah')->user();

        $activeVA = Payment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        if (!$activeVA) {
            return response()->json([
                'status' => 'empty'
            ]);
        }

        return response()->json([
            'status' => 'active',
            'bank' => strtoupper($activeVA->bank),
            'va' => $activeVA->va_number,
            'amount' => number_format($activeVA->amount),
            'expired' => $activeVA->expired_at->format('d M Y H:i'),
            'expired_raw' => $activeVA->expired_at
        ]);
    }


    // public function pay(Request $request)
    // {
    //     Config::$serverKey = config('midtrans.server_key');
    //     Config::$isProduction = config('midtrans.is_production');
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     $orderId = 'ORDER-' . Str::uuid();

    //     $params = [
    //         'transaction_details' => [
    //             'order_id' => $orderId,
    //             'gross_amount' => $request->amount,
    //         ],
    //         'customer_details' => [
    //             'first_name' => auth()->user()->username,
    //             'email' => auth()->user()->email,
    //         ],
    //     ];

    //     $snapToken = Snap::getSnapToken($params);

    //     // Simpan ke database
    //     Payment::create([
    //         'user_id' => auth()->id(),
    //         'order_id' => $orderId,
    //         'amount' => $request->amount,
    //         'status' => 'pending'
    //     ]);

    //     return response()->json([
    //         'snap_token' => $snapToken
    //     ]);
    // }

    public function finish(Request $request)
    {
        return redirect()->route('tagihanJamaah');
    }

    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');

        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $orderId = $notif->order_id;

        $payment = Payment::where('order_id', $orderId)->first();

        if ($transaction == 'settlement') {
            $payment->update(['status' => 'paid']);
        } elseif ($transaction == 'pending') {
            $payment->update(['status' => 'pending']);
        } elseif ($transaction == 'cancel' || $transaction == 'expire') {
            $payment->update(['status' => 'failed']);
        }
    }
}
