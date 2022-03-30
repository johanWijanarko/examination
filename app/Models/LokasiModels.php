<?php

namespace App\Models;

use App\Models\Kabupaten;
use App\Models\ProvinsiModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LokasiModels extends Model
{
    use HasFactory;
    protected $table = 'par_lokasi';
    protected $primaryKey = 'lokasi_id';

    protected $fillable = ['lokasi_id', 'lokasi_name', 'lokasi_provinsi_id', 'lokasi_pkabupaten_id', 'created_at', 'updated_at'];

    public function lokasihasProvinsi(){
        return $this->hasOne(ProvinsiModels::class, 'id', 'lokasi_provinsi_id');
    }

    public function lokasihaskabupaten(){
        return $this->hasOne(Kabupaten::class, 'id', 'lokasi_pkabupaten_id');
    }
}
