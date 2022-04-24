<?php

namespace App\Models;

use App\Models\Divisi;
use App\Models\Jabatan;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PegawaiModels extends Model
{
    use HasFactory, Notifiable, HasRoles;
    protected $table = 'pegawai';
    protected $primaryKey = 'pegawai_id';

    protected $fillable = ['pegawai_id', 'pegawai_nip', 'pegawai_name', 'pegawai_bagian_id','pegawai_sub_bagian_id','pegawai_alamat', 'pegawai_telp', 'pegawai_email', 'pegawai_foto', 'pegawai_del_st', 'created_at', 'updated_at'];

    public function pegawaiHasBagian()
    {
        return $this->hasOne(ParBagianModels::class, 'bagian_id', 'pegawai_bagian_id');
    }
    public function pegawaiHasSubBagian()
    {
        return $this->hasOne(SubBagianModels::class, 'sub_bagian_id', 'pegawai_sub_bagian_id');
    }

    public function pegawaiHasBagian2()
    {
        return $this->belongsTo(ParBagianModels::class, 'pegawai_bagian_id', 'bagian_id');
    }
    public function pegawaiHasSubBagian2()
    {
        return $this->belongsTo(SubBagianModels::class, 'pegawai_sub_bagian_id', 'sub_bagian_id');
    }
    public function pegawaiHasTrsDetail()
    {
        return $this->belongsTo(DetailTransaksi::class, 'pegawai_id', 'trs_detail_pegawai_id');
    }

}
