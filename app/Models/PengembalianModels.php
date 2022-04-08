<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianModels extends Model
{
    use HasFactory;
    protected $table = 'pengembalian_data';
    protected $primaryKey = 'pengembalian_id';
    protected $fillable = ['pengembalian_id', 'pengembalian_data_id', 'pengembalian_obejk_id','pengembalian_pegawai_id', 'pengembalian_kondisi_sekarang_id', 'pengembalian_kondisi_sebelum_id','pengembalian_jumlah', 'pengembalian_keterangan','pengembalian_trs_detail_id','pengembalian_pic_id','pengembalian_tgl','created_at', 'updated_at'];

    public function kembaliHasObjek(){
        return $this->belongsTo(DataManajemenModels::class, 'pengembalian_obejk_id', 'data_manajemen_id');
    }

    public function kembaliHasPegawai(){
        return $this->belongsTo(PegawaiModels::class, 'pengembalian_pegawai_id', 'pegawai_id');
    }
    public function kembaliHasKondisiSkrg(){
        return $this->belongsTo(KondisiModels::class, 'pengembalian_kondisi_sekarang_id', 'data_kondisi_id');
    }
    public function kembaliHasKondisiSblm(){
        return $this->belongsTo(KondisiModels::class, 'pengembalian_kondisi_sebelum_id', 'data_kondisi_id');
    }
    public function kembaliHasTrs(){
        return $this->belongsTo(TransaksiDataModel::class, 'pengembalian_trs_id', 'trs_id');
    }
}


