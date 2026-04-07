<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenjadwalanController extends Controller
{
    public function index(){
        return view('admin.penjadwalan.dashboard');
    }
}
