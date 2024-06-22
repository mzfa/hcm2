<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProfesiController extends Controller
{
    public function index()
    {
        $data = DB::table('profesi')
        ->whereNull('profesi.deleted_at')
        ->get();
        return view('profesi.index', compact('data'));
    }
    public function store(Request $request){
        $request->validate([
            'nama_profesi' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'nama_profesi' => $request->nama_profesi,
        ];
        DB::table('profesi')->insert($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM profesi WHERE profesi_id='$id'")){

            $text = '<div class="mb-3 form-group">'.
                    '<label>Nama Profesi</label>'.
                    '<input type="text" class="form-control" id="nama_profesi" name="nama_profesi" value="'.$data[0]->nama_profesi.'" required>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="profesi_id" name="profesi_id" value="'.Crypt::encrypt($data[0]->profesi_id) .'" required>';
        }
        return $text;
        // return view('profesi.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_profesi' => ['required'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_profesi' => $request->nama_profesi,
        ];
        $profesi_id = Crypt::decrypt($request->profesi_id);
        DB::table('profesi')->where(['profesi_id' => $profesi_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('profesi')->where(['profesi_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    public function sync()
    {
        $list_profesi_phis = DB::connection('PHIS-V2')
            ->table('profesi')
            ->select([
                'profesi_id',
                'input_time',
                'input_user_id',
                'mod_time',
                'mod_user_id',
                'status_batal',
                'nama_profesi'
            ])
            ->orderBy('profesi_id')
            ->get();

        foreach ($list_profesi_phis as $profesi) {
            if ($profesi->status_batal) {
                $deleted_at = $profesi->mod_time ?? now();
                $deleted_by = $profesi->mod_user_id ?? 1;
            } else {
                $deleted_at = null;
                $deleted_by = null;
            }
            $datanya[] = [
                'profesi_id' => $profesi->profesi_id,
                'created_at' => $profesi->input_time,
                'created_by' => $profesi->input_user_id,
                'updated_at' => $profesi->mod_time,
                'updated_by' => $profesi->mod_user_id,
                'deleted_at' => $deleted_at,
                'deleted_by' => $deleted_by,
                'nama_profesi' => $profesi->nama_profesi
            ];
        }

        DB::table('profesi')->truncate();
        DB::table('profesi')->insert($datanya);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Perbarui!']);
    }
}
