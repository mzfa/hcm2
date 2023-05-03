<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $jenis_pendidikan = DB::table('jenis_pendidikan')->whereNull('jenis_pendidikan.deleted_at')->count();
        $pegawai = DB::table('pegawai')->whereNull('pegawai.deleted_at')->count();
        $keluarga_pegawai = DB::table('keluarga_pegawai')->whereNull('keluarga_pegawai.deleted_at')->count();
        $pelatihan_pegawai = DB::table('pelatihan_pegawai')->whereNull('pelatihan_pegawai.deleted_at')->count();
        // dd($jenis_pendidikan);
        return view('home', compact('jenis_pendidikan','pegawai','keluarga_pegawai','pelatihan_pegawai'));
    }
}
