<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenggajianParttimerImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    private $data; 

    public function __construct(array $data = [])
    {
        $this->data = $data; 
    }
    public function collection(Collection $collection)
    {
        // dump($collection);
        // DB::table('penggajian_parttimer')->where(['periode_gaji' => $this->data['periode']])->delete();
        foreach($collection as $item){
            if($item[0] != 'no' && $item[2] != 'npwp'){
                $data_import = [
                    'created_by' => Auth::user()->id,
                    'created_at' => now(),
                    'nip' => $item[5],
                    'npwp' => $item[1],
                    'ptkp' => $item[2],
                    'pkwt' => $item[3],
                    'no_rek' => $item[4],
                    'nama' => $item[6],
                    'bagian' => $item[7],
                    'pendidikan' => $item[9],
                    'kelas_jabatan' => $item[10],
                    'iki' => $item[21],
                    'upah_per_shift' => $item[22],
                    'total_remun' => $item[23],
                    'jumlah_kehadiran' => $item[24],
                    'tunj_jabatan' => $item[25],
                    'penyesuaian' => $item[26],
                    'total_gaji' => $item[27],
                    'overtime' => $item[28],
                    'double_job' => $item[29],
                    'rapel' => $item[30],
                    'pph_21_dtp' => $item[31],
                    'jumlah_gaji' => $item[32],
                    'bpjs_kesehatan' => $item[33],
                    'bpjs_tk' => $item[34],
                    'pph_21' => $item[35],
                    'kesra' => $item[36],
                    'parkir' => $item[37],
                    'pinjaman' => $item[38],
                    'pemotongan_obat' => $item[39],
                    'lain_lain' => $item[40],
                    'potongan_koperasi' => $item[41],
                    'potongan_absensi' => $item[42],
                    'total_pengurang' => $item[45],
                    'gaji_bersih' => $item[46],
                    'periode_gaji' => $this->data['periode'],
                    'status_kepegawaian_manual' => $item[52],
                ];
                // dd($data_import);
                DB::table('penggajian_parttimer')->insert($data_import);
            }
            // dump($data_import);
        }
    }
}
