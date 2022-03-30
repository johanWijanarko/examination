<?php

namespace App\Models;

use App\Models\GedungModels;
use App\Models\KondisiModels;
use App\Models\PegawaiModels;
use App\Models\RuanganModels;
use App\Models\ParBagianModels;
use App\Models\SubBagianModels;
use App\Models\DataKelompokModels;
use App\Models\DataManajemenModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiDataModel extends Model
{
    use HasFactory;
    protected $table = 'transaksi_data';
    protected $primaryKey = 'trs_id';

    protected $fillable = ['trs_id', 'trs_kode', 'trs_jenis_id','trs_data_id', 'trs_name', 'trs_pegawai_id', 'trs_bagian_id', 'trs_sub_bagian_id', 'trs_kelompok_id', 'trs_gedung_id', 'trs_ruangan_id','trs_pic_id','trs_kondisi_id','trs_status_id','trs_date','created_at', 'updated_at'];

    public function trsHasData(){
        return $this->belongsTo(DataManajemenModels::class, 'trs_data_id', 'data_manajemen_id');
    }

    public function trsHasPegawai(){
        return $this->belongsTo(PegawaiModels::class, 'trs_pegawai_id', 'pegawai_id');
    }

    public function trsHasSubBagian(){
        return $this->belongsTo(SubBagianModels::class, 'trs_sub_bagian_id', 'sub_bagian_id');   
    }

    public function trsHasBagian(){
        return $this->belongsTo(ParBagianModels::class, 'trs_bagian_id', 'bagian_id');
    }

    public function trsHasPic(){
        return $this->belongsTo(User::class, 'trs_pic_id', 'id');
    }
    public function trsHasGedung(){
        return $this->belongsTo(GedungModels::class, 'trs_gedung_id', 'data_gedung_id');
    }

    public function trsHasRuangan(){
        return $this->belongsTo(RuanganModels::class, 'trs_ruangan_id', 'data_ruangan_id');
    }

    public function trsHasKelompok(){
        return $this->belongsTo(DataKelompokModels::class, 'trs_kelompok_id', 'data_kelompok_id');
    }
    public function trsHasKondisi(){
        return $this->belongsTo(KondisiModels::class, 'trs_kondisi_id', 'data_kondisi_id');
    }
    
}
