<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiHasDetail extends Model
{
    use HasFactory;
    protected $table = 'mutasi_has_detail';
    protected $primaryKey = 'detail_id';
    protected $fillable = ['detail_id','detail_mutasi_id', 'detail_mutasi_trs_id', 'detail_mutasi_pegawai_id', 'detail_mutasi_gedung_id', 'detail_mutasi_ruangan_id', 'detail_mutasi_kondisi_id','detail_mutasi_tgl','created_at', 'updated_at'];

    public function DetailMutasiHasPegawai()
    {
        return $this->belongsTo(PegawaiModels::class, 'detail_mutasi_pegawai_id', 'pegawai_id');
    }

    public function DetailMutasiHasGedung()
    {
        return $this->belongsTo(GedungModels::class, 'detail_mutasi_gedung_id', 'data_gedung_id');
    }
    public function DetailMutasiHasRuangan()
    {
        return $this->belongsTo(RuanganModels::class, 'detail_mutasi_ruangan_id', 'data_ruangan_id');
    }
    public function DetailMutasiHasKondisi()
    {
        return $this->belongsTo(KondisiModels::class, 'detail_mutasi_kondisi_id', 'data_kondisi_id');
    }
    public function mutasiParent(){
        return $this->belongsTo(MutasiModels::class, 'detail_mutasi_id', 'mutasi_id');
    }
}
