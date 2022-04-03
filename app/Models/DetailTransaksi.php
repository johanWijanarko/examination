<?php

namespace App\Models;

use App\Models\StokModels;
use App\Models\PegawaiModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'trs_detail';
    protected $primaryKey = 'trs_detail_id';

    protected $fillable = ['trs_detail_id','trs_id', 'trs_detail_pegawai_id', 'trs_detail_data_stok_id', 'trs_detail_gedung_id', 'trs_detail_ruangan', 'trs_detail_jumlah'];

    public function trsHasStok2(){
        return $this->belongsTo(StokModels::class, 'trs_detail_data_stok_id', 'data_stok_id');
    }
    public function trsHasPegawai2(){
        return $this->belongsTo(PegawaiModels::class, 'trs_detail_pegawai_id', 'pegawai_id');
    }
}
