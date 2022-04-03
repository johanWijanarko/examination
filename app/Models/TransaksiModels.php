<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiModels extends Model
{
    use HasFactory;
    protected $table = 'trs_inventaris';
    protected $primaryKey = 'trs_id';

    protected $fillable = ['trs_id', 'trs_kode', 'trs_data_stok_id','trs_gedung_id', 'trs_ruang_id', 'trs_pic_id', 'trs_status_id', 'trs_date', 'trs_keterangan', 'trs_pegawai_id','created_at', 'updated_at'];

    public function trsHasStok(){
        return $this->belongsTo(StokModels::class, 'trs_data_stok_id', 'data_stok_id');
    }

    public function trsHasPegawai(){
        return $this->belongsTo(PegawaiModels::class, 'trs_pegawai_id', 'pegawai_id');
    }

    public function trsHasGedung(){
        return $this->belongsTo(GedungModels::class, 'trs_gedung_id', 'data_gedung_id');
    }

    public function trsHasRuangan(){
        return $this->belongsTo(RuanganModels::class, 'trs_ruang_id', 'data_ruangan_id');
    }

    public function trsHasPic(){
        return $this->belongsTo(User::class, 'trs_pic_id', 'id');
    }

    public function trsDetail(){
        return $this->hasMany(DetailTransaksi::class, 'trs_id', 'trs_id');
    }
}
