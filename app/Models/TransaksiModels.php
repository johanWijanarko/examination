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
}
