<?php

namespace App\Traits;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait KasTransaction{
    public function getSaldo($tgl1){
      
        $p = Carbon::create($tgl1);
        $periode = $p->format('Y-m');
        $awal = $p->add(-1,'month')->format('Y-m');
        $awal1 = $periode."-01";
     
     $saldo_awal = DB::select("select saldo_akhir from laporan where periode = '$awal'");
     if (!$saldo_awal) {
        $saldo_awal = 0;
     }
     /*
     $masuk1 = DB::select("select sum(jumlah) as jumlah from transaksi where id_masuk is not null and tgl_transaksi < '$tgl1' and tgl_transaksi >= '$awal1'")[0]->jumlah;
     if (!$masuk1) {
        $masuk1 = 0;
     }
     $keluar1 = DB::select("select sum(jumlah) as jumlah from transaksi where id_keluar is not null and tgl_transaksi < '$tgl1' and tgl_transaksi >= '$awal1'")[0]->jumlah;
     if (!$keluar1) {
        $keluar1 = 0;
     }
     */
     $masuk = DB::select("select sum(jumlah) as jumlah from transaksi where id_masuk is not null and tgl_transaksi >= '$awal1' and tgl_transaksi <= '$tgl1'")[0]->jumlah;
     if (!$masuk) {
        $masuk = 0;
     }
     $keluar = DB::select("select sum(jumlah) as jumlah from transaksi where id_keluar is not null and tgl_transaksi >= '$awal1' and tgl_transaksi <= '$tgl1'")[0]->jumlah;
     if (!$keluar) {
        $keluar = 0;
     }
 
     $saldo = $saldo_awal+ $masuk - $keluar;
     return array(
         "awal"=> $saldo_awal,
         "masuk" => $masuk,
         "keluar" => $keluar,
         "saldo" => $saldo,
     );
 
    }
}