<?php

namespace App\Models;

use App\Models\MutasiHasDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MutasiModels extends Model
{
    use HasFactory;
    protected $table = 'mutasi';
    protected $primaryKey = 'mutasi_id';
    protected $fillable = ['mutasi_id', 'mutasi_keterangan','mutasi_data_id','mutasi_trs_id', 'mutasi_objek_id','mutasi_pegawai_id', 'mutasi_kondisi_id', 'mutasi_gedung_id','mutasi_ruangan_id','mutasi_pic_id', 'mutasi_tgl','created_at', 'updated_at'];

    public function MutasiHasPegawai()
    {
        return $this->belongsTo(PegawaiModels::class, 'mutasi_pegawai_id', 'pegawai_id');
    }

    public function mutasiHasKondisi(){
        return $this->belongsTo(KondisiModels::class, 'mutasi_kondisi_id', 'data_kondisi_id');
    }

     public function mutasiHasManajemen(){
        return $this->belongsTo(DataManajemenModels::class, 'mutasi_objek_id', 'data_manajemen_id');
    }
    public function mutasiHasdetail(){
        return $this->belongsTo(MutasiHasDetail::class, 'mutasi_id', 'detail_mutasi_id');
    }
    public function MutasiHasGedung()
    {
        return $this->belongsTo(GedungModels::class, 'mutasi_gedung_id', 'data_gedung_id');
    }
    public function MutasiHasRuangan()
    {
        return $this->belongsTo(RuanganModels::class, 'mutasi_ruangan_id', 'data_ruangan_id');
    }
}
