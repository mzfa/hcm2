<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PegawaiController extends Controller
{
    public function index()
    {
        $data = DB::table('pegawai')
        ->leftJoin('bagian', 'pegawai.bagian_id', '=', 'bagian.bagian_id')
        ->leftJoin('profesi', 'pegawai.profesi_id', '=', 'profesi.profesi_id')
        ->leftJoin('pegawai_detail', 'pegawai.pegawai_id', '=', 'pegawai_detail.pegawai_id')
        ->leftJoin('struktur', 'pegawai_detail.struktur_id', '=', 'struktur.struktur_id')
        ->select([
            'pegawai.pegawai_id',
            'pegawai.nama_pegawai',
            'pegawai_detail.struktur_id',
            'struktur.nama_struktur',
            'pegawai.nip',
            'bagian.nama_bagian',
            'profesi.nama_profesi'
        ])
        ->whereNull('pegawai.deleted_at')
        ->get();
        return view('pegawai.index', compact('data'));
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $data = DB::table('users')
        ->leftJoin('pegawai', 'users.pegawai_id', '=', 'pegawai.pegawai_id')
        ->leftJoin('pegawai_detail', 'users.pegawai_id', '=', 'pegawai_detail.pegawai_id')
        ->leftJoin('bagian', 'pegawai.bagian_id', '=', 'bagian.bagian_id')
        ->leftJoin('profesi', 'pegawai.profesi_id', '=', 'profesi.profesi_id')
        ->select([
            'users.username',
            'pegawai.*',
            'pegawai.pegawai_id AS idpeg',
            'pegawai_detail.*',
            'bagian.nama_bagian',
            'profesi.nama_profesi'
        ])
        ->whereNull('pegawai.deleted_at')
        ->where(['pegawai.pegawai_id' => $id])
        ->first();
        $struktur = DB::table('struktur')->get();
        // $provinsi = DB::table('pegawai_detail')->distinct()->get(['provinsi']);
        // $kabupaten = DB::table('pegawai_detail')->distinct()->get(['kabupaten']);
        // $data = DB::select("SELECT * FROM pegawai WHERE pegawai_id='$id'");
        return view('pegawai.edit', compact('data','struktur'));
    }

    public function update(Request $request){
        // dd($request);
        $pegawai_detail_id = $request->pegawai_detail_id;
        $data = [
            'alamat_lengkap' => $request->alamat_lengkap,
            'provinsi' => $request->provinsi,
            'kelurahan' => $request->kelurahan,
            'kabupaten' => $request->kabupaten,
            'kode_pos' => $request->kode_pos,
            'struktur_id' => $request->struktur_id,
            'telp_pribadi' => $request->telp_pribadi,
            'telp_keluarga' => $request->telp_keluarga,
            'pegawai_id' => $request->pegawai_id,
        ];
        $cek = DB::table('pegawai_detail')->where(['pegawai_detail_id' => $pegawai_detail_id])->first();
        // dd($data);
        if(isset($cek)){
            DB::table('pegawai_detail')
            ->where(['pegawai_detail_id' => $pegawai_detail_id])
            ->update(
                $data
            );
        }else{
            DB::table('pegawai_detail')
            ->insert(
                $data
            );
        }
        return Redirect('pegawai')->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function sync()
    {
        // dd("ok");
        $list_pegawai_phis = DB::connection('PHIS-V2')
        ->table('pegawai')
        ->select([
            'pegawai_id',
            'input_time',
            'input_user_id',
            'mod_time',
            'mod_user_id',
            'status_batal',
            'nama_pegawai',
            'nip',
            'bagian_id',
            'profesi_id'
        ])
        ->orderBy('pegawai_id')
        ->get();

        foreach ($list_pegawai_phis as $pegawai) {
            if ($pegawai->status_batal) {
                $deleted_at = $pegawai->mod_time ?? now();
                $deleted_by = $pegawai->mod_user_id ?? 1;
            } else {
                $deleted_at = null;
                $deleted_by = null;
            }
            $datanya[] = [
                'pegawai_id' => $pegawai->pegawai_id,
                'created_at' => $pegawai->input_time,
                'created_by' => $pegawai->input_user_id,
                'updated_at' => $pegawai->mod_time,
                'updated_by' => $pegawai->mod_user_id,
                'deleted_at' => $deleted_at,
                'deleted_by' => $deleted_by,
                'nama_pegawai' => $pegawai->nama_pegawai,
                'nip' => $pegawai->nip,
                'bagian_id' => $pegawai->bagian_id,
                'profesi_id' => $pegawai->profesi_id
            ];
        }

        DB::table('pegawai')->truncate();
        DB::table('pegawai')->insert($datanya);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Perbarui!']);

        // return redirect()->back()->with('status', ['success', 'Data berhasil disimpan']);
    }
}
