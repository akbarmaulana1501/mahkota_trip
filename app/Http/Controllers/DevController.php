<?php

namespace App\Http\Controllers;

use App\Models\Log_activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DevController extends Controller
{
    private $dir = 'developer';

    public function index()
    {
        return view($this->dir . '.dashboard');
    }

    public function log_aktivitas()
    {
        $logs = Log_activity::with('user')->latest()->paginate(20);
        return view($this->dir . '.log_activities.tampil_data', compact('logs'));
    }

    public function log_error()
    {
        $path = storage_path('logs/laravel.log');

        if (!File::exists($path)) {
            $logs = [];
        } else {
            $content = File::get($path);

            // pecah log per entry
            $logs = array_reverse(preg_split('/\n(?=\[)/', $content));
        }

        $logs = array_slice($logs, 0, 50);

        return view($this->dir . '.log_error.tampil_data', compact('logs'));
    }
}
