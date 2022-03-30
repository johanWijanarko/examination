<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataManajemenModels extends Model
{
    use HasFactory;
    protected $table = 'data_manajemen';
    protected $primaryKey = 'data_manajemen_id';

    protected $fillable = ['data_manajemen_id', 'data_manajemen_kode_id', 'data_manajemen_name', 'data_manajemen_merk_id',
    'data_manajemen_type_id', 'data_manajemen_kondisi_id', 'data_manajemen_jumlah_awal','data_manajemen_jumlah_mutasi', 'data_manajemen_jumlah_pinjam', 'data_manajemen_jumlah','data_manajemen_keterangan','data_manajemen_supplier_id','data_manajemen_jumlah_pemakai','data_manajemen_jumlah_rusak','created_at', 'updated_at'];

    public function manajemenHasMerk(){
        return $this->belongsTo(DataMerkModels::class, 'data_manajemen_merk_id', 'data_merk_id');
    }

    public function manajemenHasType(){
        return $this->belongsTo(TypeKtegoryModels::class, 'data_manajemen_type_id', 'data_type_id');
    }

    public function manajemenHasKondisi(){
        return $this->belongsTo(KondisiModels::class, 'data_manajemen_kondisi_id', 'data_kondisi_id');   
    }
    
    public function manajemenHasSupplier(){
        return $this->belongsTo(SupplierModels::class, 'data_manajemen_supplier_id', 'supplier_id');
    }
}
