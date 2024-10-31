<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PerhitunganPPH21Import;
use PDF;
use PhpOffice\PhpSpreadsheet\Writer\Pdf as WriterPdf;

class PerhitunganPPH21Controller extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $pegawai = DB::table('pegawai')->whereNull('deleted_at')->get();
        $waktu_awal = date('Y-m-d',strtotime(date('Y-').'01-01'));
        $waktu_akhir = date('Y-m-d',strtotime(date('Y-').'12-31'));
        // dd($waktu_awal);    
        $pph21 = DB::select("SELECT * FROM perhitungan_pph21 WHERE tanggal_pemotongan BETWEEN '$waktu_awal' AND '$waktu_akhir'");
        $datanya = [];
        $data_pph = [];
        foreach ($pph21 as $value) {
            $data_pph[$value->nip][$value->periode] = $value->pph_21_gaji;
        }
        // dump($data_pph);
        foreach($pegawai as $item){
            $data1 = [
                'nama_pegawai' => $item->nama_pegawai,
                'npwp' => $item->npwp,
                'jk' => $item->jk,
                'nip' => $item->nip,
            ];
            for ($i=1; $i <= 12; $i++) { 
                $bulan = date('Y').sprintf('%02s',$i);
                $item2 = $data_pph[$item->nip][$bulan] ?? '-';
                array_push($data1,$item2);
            }
            $datanya[] = $data1; 
        }
        $perhitungan_pph21 = DB::table('perhitungan_pph21')->whereNull('perhitungan_pph21.deleted_at')->get();
        return view('penggajian.perhitungan_pph21.index', compact('perhitungan_pph21','datanya'));
    }
    public function import(Request $request){
        // dd(str_replace("-",'', $request->periode));
        $data = [
            'periode' => str_replace("-",'', $request->periode),
        ];
        Excel::import(new PerhitunganPPH21Import($data), $request->file('file')->store('temp'));
        return back();
    }

    public function store(Request $request){
        $request->validate([
            'jenis_pendidikan_id' => ['required'],
            'nama_instansi' => ['required'],
            'jurusan' => ['required'],
            'tahun_mulai' => ['required'],
            'tahun_lulus' => ['required'],
        ]);
        $data = [
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'jenis_pendidikan_id' => $request->jenis_pendidikan_id,
            'nama_instansi' => $request->nama_instansi,
            'jurusan' => $request->jurusan,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_lulus' => $request->tahun_lulus,
        ];
        DB::table('pendidikan')->insert($data);

        return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!']);
    }

    public function edit($id)
    {
        // $id = Crypt::decrypt($id);
        // dd($data);
        $text = "Data tidak ditemukan";
        if($data = DB::select("SELECT * FROM pendidikan WHERE pendidikan_id='$id'")){
            $jurusan = DB::table('pendidikan')->distinct()->get(['jurusan']);

            $text = '<div class="mb-3 row">'.
                '<label for="staticEmail" class="col-sm-12 col-form-label">Nama Instansi</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="nama_instansi" name="nama_instansi" value="'.$data[0]->nama_instansi.'" required>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Jurusan/Fakultas</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" list="datalistjurusan" name="jurusan" class="form-control" id="address4" value="'.$data[0]->jurusan.'" placeholder="Select Jurusan">'.
                            '<datalist id="datalistjurusan">';
                                foreach($jurusan as $item){
                                    $text .= '<option value="'.$item->jurusan.'">';
                                }
                            $text .='</datalist>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Tahun Mulai</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="tahun_mulai" name="tahun_mulai" value="'.$data[0]->tahun_mulai.'" required>'.
                    '</div>'.
                '</div>'.
                '<div class="mb-3 row">'.
                    '<label for="staticEmail" class="col-sm-12 col-form-label">Tahun Lulus</label>'.
                    '<div class="col-sm-12">'.
                    '<input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus" value="'.$data[0]->tahun_lulus.'" required>'.
                    '</div>'.
                '</div>'.
                '<input type="hidden" class="form-control" id="pendidikan_id" name="pendidikan_id" value="'.Crypt::encrypt($data[0]->pendidikan_id) .'" required>';
        }
        return $text;
        // return view('pendidikan.edit');
    }

    public function update(Request $request){
        $request->validate([
            'nama_instansi' => ['required'],
            'jurusan' => ['required'],
            'tahun_mulai' => ['required'],
            'tahun_lulus' => ['required'],
        ]);
        $data = [
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
            'nama_instansi' => $request->nama_instansi,
            'jurusan' => $request->jurusan,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_lulus' => $request->tahun_lulus,
        ];
        $pendidikan_id = Crypt::decrypt($request->pendidikan_id);
        $status_pendidikan = "Aktif";
        DB::table('pendidikan')->where(['pendidikan_id' => $pendidikan_id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
    }
    public function delete($id){
        $id = Crypt::decrypt($id);
        $data = [
            'deleted_by' => Auth::user()->id,
            'deleted_at' => now(),
        ];
        DB::table('pendidikan')->where(['pendidikan_id' => $id])->update($data);
        return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus!']);
    }

    public function detail($id)
    {
        $id = Crypt::decrypt($id);
        $data = DB::table('perhitungan_pph21')->leftJoin('pegawai','perhitungan_pph21.nip','pegawai.nip')->where('perhitungan_pph21_id',$id)->whereNull('perhitungan_pph21.deleted_at')->first();
        return view('penggajian.perhitungan_pph21.detail', compact('data','id'));
    }
    // public function createPDF(){
    //     // retreive all records from db
    //     // $data = DB::table('perhitungan_pph21')->leftJoin('pegawai','perhitungan_pph21.nip','pegawai.nip')->where('perhitungan_pph21_id',$id)->whereNull('perhitungan_pph21.deleted_at')->first();
    //     // share data to view
    //     $data = [];
    //     view()->share('employee',$data);
    //     $pdf = PDF::loadView('tesprint', $data);
    //     // download PDF file with download method
    //     return $pdf->download('pdf_file.pdf');
    //   }
    
}
