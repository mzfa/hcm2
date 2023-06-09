<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SlipGajiController extends Controller
{
    public function index()
    {
        $pegawai_id = Auth::user()->pegawai_id;
        $pegawai = DB::table('pegawai')->where('pegawai_id', $pegawai_id)->first();
        $data = DB::table('penggajian')->whereNull('penggajian.deleted_at')->where('nip',$pegawai->nip)->orderBy('periode_gaji','asc')->get();
        // dd($data);
        return view('penggajian.slip_gaji.index', compact('data'));
    }
    public function detail($id)
    {
        $id = Crypt::decrypt($id);
        $data = DB::table('penggajian')->leftJoin('pegawai','penggajian.nip','pegawai.nip')->where('penggajian_id',$id)->whereNull('penggajian.deleted_at')->first();
        return view('penggajian.penggajian_manual.detail', compact('data'));
    }
    
}
