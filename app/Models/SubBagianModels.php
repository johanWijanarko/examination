<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubBagianModels extends Model
{
    use HasFactory;
    protected $table = 'par_sub_bagian';
    protected $primaryKey = 'sub_bagian_id';
    protected $fillable = ['sub_bagian_id', 'sub_bagian_bagian_id', 'sub_bagian_kode', 'sub_bagian_nama','created_at', 'updated_at'];

    public function getBagian(){
        return $this->hasOne(ParBagianModels::class, 'bagian_id', 'sub_bagian_bagian_id');
    }
}
