<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PerhitunganPPH21Import implements ToCollection
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
        // dd($collection);
        DB::table('perhitungan_pph21')->where(['periode' => $this->data['periode']])->delete();
        foreach($collection as $item){
            if($item[0] != 'NO.' && $item[1] != 'NAMA'){
                $tanggalan = date('Y-m-d',strtotime(Str::replace('/','-',$item[34])));
                $data_import = [
                    'created_by' => Auth::user()->id,
                    'created_at' => now(),
                    'nip' => $item[2],
                    'nama' => $item[1],
                    'metode_pembayaran' => $item[3],
                    'ptkp' => $item[4],
                    'gaji' => $item[5],
                    'index_prestasi' => $item[6],
                    'tunjangan_prestasi' => $item[7],
                    'penyesuaian' => $item[8],
                    'overtime' => $item[9],
                    'double_job' => $item[10],
                    'rapel' => $item[11],
                    'tunjangan_transport' => $item[12],
                    'ph_bruto_teratur' => $item[13],
                    'gross_up' => $item[14],
                    'non_gross_up' => $item[15],
                    'total_tunjangan' => $item[16],
                    'premi_jkk' => $item[18],
                    'premi_jkm' => $item[19],
                    'premi_bpjs_kes' => $item[20],
                    'total_premi' => $item[21],
                    'jumlah_penghasilan_teratur' => $item[29],
                    'jumlah_penghasilan_bruto' => $item[30],
                    'kategori_ter' => $item[31],
                    'tarif_efektif_rata_rata' => $item[32],
                    'pph_21_gaji' => $item[33],
                    'tanggal_pemotongan' => $tanggalan,
                    // 'periode_gaji' => $item[30],
                    'periode' => $this->data['periode'],
                ];
                // dd($data_import);
                DB::table('perhitungan_pph21')->insert($data_import);
            }
            // dump($data_import);
        }
    }
}
