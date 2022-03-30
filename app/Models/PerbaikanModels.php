<?php

namespace App\Models;

use App\Models\TransaksiDataModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerbaikanModels extends Model
{
    use HasFactory;
    protected $table = 'perbaikan';
    protected $primaryKey = 'perbaikan_id';
    protected $fillable = ['perbaikan_id', 'perbaikan_data_id', 'perbaikan_objek_id','perbaikan_pegawai_id', 'perbaikan_trs_id', 'perbaikan_tgl_in', 'perbaikan_estimasi','perbaikan_keterangan','perbaikan_pic_id','perbaikan_status','perbaikan_tgl','created_at', 'updated_at'];

     public function perbaikanHasObjek(){
        return $this->belongsTo(DataManajemenModels::class, 'perbaikan_objek_id', 'data_manajemen_id');
    }
    public function perbaikanHasPegawai(){
        return $this->belongsTo(PegawaiModels::class, 'perbaikan_pegawai_id', 'pegawai_id');
    }
    public function perbaikanHasTrs(){
        return $this->belongsTo(TransaksiDataModel::class, 'perbaikan_trs_id', 'trs_id');
    }
}
