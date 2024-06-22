<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class BagianController extends Controller
{
    // public function index()
    // {
    //     $data = DB::table('bagian_1')
    //     ->whereNull('bagian.deleted_at')
    //     ->get();
    //     return view('bagian_1', compact('data'));
    // }

    // public function sync()
    // {
    //     $list_bagian_phis = DB::connection('PHIS-V2')
    //         ->table('bagian_1')
    //         ->select([
    //             'bagian_id',
    //             'input_time',
    //             'input_user_id',
    //             'mod_time',
    //             'mod_user_id',
    //             'status_batal',
    //             'nama_bagian',
    //             'referensi_bagian',
    //             'group_bagian',
    //         ])
    //         ->orderBy('bagian_id')
    //         ->get();

    //     foreach ($list_bagian_phis as $bagian) {
    //         if ($bagian->status_batal) {
    //             $deleted_at = $bagian->mod_time ?? now();
    //             $deleted_by = $bagian->mod_user_id ?? 1;
    //         } else {
    //             $deleted_at = null;
    //             $deleted_by = null;
    //         }
    //         $datanya[] = [
    //             'bagian_id' => $bagian->bagian_id,
    //             'created_at' => $bagian->input_time,
    //             'created_by' => $bagian->input_user_id,
    //             'updated_at' => $bagian->mod_time,
    //             'updated_by' => $bagian->mod_user_id,
    //             'deleted_at' => $deleted_at,
    //             'deleted_by' => $deleted_by,
    //             // 'referensi_id' => $bagian->referensi_bagian,
    //             'referensi_bagian' => $bagian->referensi_bagian,
    //             'nama_bagian' => $bagian->nama_bagian
    //         ];
    //     }

    //     DB::table('bagian_1')->truncate();
    //     DB::table('bagian_1')->insert($datanya);
    //     return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);

    //     // return redirect()->back()->with('status', ['success', 'Data berhasil disimpan']);
    // }
    public function index()
    {
        $bagian = DB::table('bagian_1')->whereNull('deleted_at')->get();
        $data = DB::table('bagian_1')->whereNull('deleted_at')->whereNull('referensi_id')->get();
        $data_bagian = [];
        foreach($data as $key => $item){
            array_push($data_bagian,[
                'id' => $item->id,
                'uuid' => $item->uuid,
                'nama' => $item->nama,
                'sub_bagian' => [],
            ]);
            $data1 = DB::table('bagian_1')->whereNull('deleted_at')->where('referensi_id', $item->id)->get();
            foreach($data1 as $key1 => $item1){
                array_push($data_bagian[$key]['sub_bagian'],[
                    'id' => $item1->id,
                    'uuid' => $item1->uuid,
                    'nama' => $item1->nama,
                    'sub_bagian' => [],
                ]);
                $data2 = DB::table('bagian_1')->whereNull('deleted_at')->where('referensi_id', $item1->id)->get();
                foreach($data2 as $key2 => $item2){
                    array_push($data_bagian[$key]['sub_bagian'][$key1]['sub_bagian'],[
                        'id' => $item2->id,
                        'uuid' => $item2->uuid,
                        'nama' => $item2->nama,
                        'sub_bagian' => [],
                    ]);
                    $data3 = DB::table('bagian_1')->whereNull('deleted_at')->where('referensi_id', $item2->id)->get();
                    foreach($data3 as $key3 => $item3){
                        array_push($data_bagian[$key]['sub_bagian'][$key1]['sub_bagian'][$key2]['sub_bagian'],[
                            'id' => $item3->id,
                            'uuid' => $item3->uuid,
                            'nama' => $item3->nama,
                            'sub_bagian' => [],
                        ]);
                    }
                }
            }
        }
        // dd($data_bagian);
        return view('bagian.index', compact('data_bagian','bagian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:255',
        ]);
        // dd($request);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'uuid' => (string) Str::uuid(),
            'nama' => $request->nama,
            'referensi_id' => $request->referensi_id,
        ];
        DB::table('bagian_1')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit(string $id)
    {
        $bagian = DB::table('bagian_1')->whereNull('deleted_at')->get();
        $data = DB::table('bagian_1')->whereNull('deleted_at')->where('uuid', $id)->first();
        return view('bagian.edit', compact('data','bagian'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:255',
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama' => $request->nama,
            'referensi_id' => $request->referensi_id,
        ];
        DB::table('bagian_1')->where(['uuid' => $request->uuid])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function destroy(string $id)
    {
        // dd($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('bagian_1')->whereNull('deleted_at')->where(['uuid' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    public function active(string $id)
    {
        $data = [
            'deleted_by' => null,
            'deleted_at' => null,
        ];
        DB::table('bagian_1')->where(['uuid' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Aktifkan kembali!']);
    }
}
