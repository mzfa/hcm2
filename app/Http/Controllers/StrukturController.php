<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StrukturController extends Controller
{
    public function index()
    {
        $struktur = [];
        $data = DB::table('struktur')->where(['parent_id' => 0])->whereNull('deleted_at')->get();
        // dd($data);
        foreach($data as $key => $item)
        {
            array_push($struktur, [
                'struktur_id' => $item->struktur_id,
                'nama_struktur' => $item->nama_struktur,
                'parent_id' => $item->parent_id,
                'akronim' => $item->akronim,
                'substruktur' => []
            ]);
            $struktur_id = $item->struktur_id;
            $substruktur1 = DB::table('struktur')->where(['parent_id' => $struktur_id])->whereNull('deleted_at')->get();
            // dd($substruktur1);
            foreach($substruktur1 as $key1 => $sub1)
            {
                array_push($struktur[$key]["substruktur"], [
                    "struktur_id" => $sub1->struktur_id,
                    "nama_struktur" => $sub1->nama_struktur,
                    "akronim" => $sub1->akronim,
                    'substruktur1' => [],
                ]);

                $struktur_id1 = $sub1->struktur_id;
                $substruktur2 = DB::table('struktur')->where(['parent_id' => $struktur_id1])->whereNull('deleted_at')->get();
                // dd($struktur['substruktur']);
                foreach($substruktur2 as $key2 => $sub2)
                {
                    // dd($key1);
                    array_push($struktur[$key]["substruktur"][$key1]["substruktur1"], [
                        "struktur_id" => $sub2->struktur_id,
                        "nama_struktur" => $sub2->nama_struktur,
                        "akronim" => $sub2->akronim,
                        'substruktur2' => [],
                    ]);

                    $struktur_id2 = $sub2->struktur_id;
                    $substruktur3 = DB::table('struktur')->where(['parent_id' => $struktur_id2])->whereNull('deleted_at')->get();
                    // dd($struktur['substruktur']);
                    foreach($substruktur3 as $key3 => $sub3)
                    {
                        array_push($struktur[$key]["substruktur"][$key1]["substruktur1"][$key2]["substruktur2"], [
                            "struktur_id" => $sub3->struktur_id,
                            "nama_struktur" => $sub3->nama_struktur,
                            "akronim" => $sub3->akronim,
                            'substruktur3' => [],
                        ]);

                        $struktur_id3 = $sub3->struktur_id;
                        $substruktur4 = DB::table('struktur')->where(['parent_id' => $struktur_id3])->whereNull('deleted_at')->get();
                        // dd($struktur['substruktur']);
                        foreach($substruktur4 as $key4 => $sub4)
                        {
                            array_push($struktur[$key]["substruktur"][$key1]["substruktur1"][$key2]["substruktur2"][$key3]["substruktur3"], [
                                "struktur_id" => $sub4->struktur_id,
                                "nama_struktur" => $sub4->nama_struktur,
                                "akronim" => $sub4->akronim,
                                'substruktur' => [],
                            ]);

                            $struktur_id4 = $sub4->struktur_id;
                            $substruktur5 = DB::table('struktur')->where(['parent_id' => $struktur_id4])->whereNull('deleted_at')->get();
                            // dd($struktur['substruktur']);
                        }
                    }
                }
            }
        }
        // dd($struktur);
        return view('struktur.index', compact('struktur'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_struktur' => ['required', 'string'],
        ]);
        $parent_id = 0;
        if(isset($request->parent_id)){
            $parent_id = $request->parent_id;
        }
        $data = [
            'nama_struktur' => $request->nama_struktur,
            'akronim' => $request->akronim,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'parent_id' => $parent_id,
        ];

        DB::table('struktur')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::table('struktur')->where(['struktur_id' => $id])->first()){

            $text = '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-2 col-form-label">Nama struktur</label>'.
                    '<div class="col-sm-10">'.
                    '<input type="text" class="form-control" id="nama_struktur" name="nama_struktur" value="'.$data->nama_struktur.'" required>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-2 col-form-label">Akronim (Singkatan)</label>'.
                    '<div class="col-sm-10">'.
                    '<input type="text" class="form-control" id="akronim" name="akronim" value="'.$data->akronim.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="struktur_id" name="struktur_id" value="'.Crypt::encrypt($data->struktur_id) .'" required>';
        }
        return $text;
        // return view('admin.struktur.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_struktur' => ['required', 'string'],
        ]);
        // dd($request);
        $data = [
            'nama_struktur' => $request->nama_struktur,
            'akronim' => $request->akronim,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ];
        $struktur_id = Crypt::decrypt($request->struktur_id);
        DB::table('struktur')->where(['struktur_id' => $struktur_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }

    public function delete($id){
        $id = Crypt::decrypt($id);
        // if($data = DB::select("SELECT * FROM tbl_struktur WHERE struktur_id='$id'")){
        //     DB::select("DELETE FROM tbl_struktur WHERE struktur_id='$id'");
        // }
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('struktur')->where(['struktur_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }
    
}
