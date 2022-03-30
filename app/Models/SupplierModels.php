<?php

namespace App\Models;

use App\Models\Kabupaten;
use App\Models\ProvinsiModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierModels extends Model
{
    use HasFactory;
    protected $table = 'par_supplier';
    protected $primaryKey = 'supplier_id';

    protected $fillable = ['supplier_id', 'supplier_kode', 'supplier_name', 'supplier_alamat', 'supplier_provinsi_id' , 'supplier_kabupaten_id', 'created_at', 'updated_at'];

    public function supplierhasProvinsi(){
        return $this->hasOne(ProvinsiModels::class, 'id', 'supplier_provinsi_id');
    }

    public function supplierhaskabupaten(){
        return $this->hasOne(Kabupaten::class, 'id', 'supplier_kabupaten_id');
    }
}
