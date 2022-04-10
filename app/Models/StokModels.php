<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokModels extends Model
{
    use HasFactory;
    protected $table = 'data_stok_inventaris';
    protected $primaryKey = 'data_stok_id';

    protected $fillable = ['data_stok_id', 'data_name', 'data_kategory_id', 'data_merk_id',
    'data_kondisi_id', 'data_supplier_id', 'data_jumlah','data_dipakai', 'data_rusak', 'data_status_id','data_keterangan','created_at', 'updated_at'];

    public function stokHasMerk(){
        return $this->belongsTo(DataMerkModels::class, 'data_merk_id', 'data_merk_id');
    }

    public function stokHasType(){
        return $this->belongsTo(TypeKtegoryModels::class, 'data_kategory_id', 'data_type_id');
    }

    public function stokHasKondisi(){
        return $this->belongsTo(KondisiModels::class, 'data_kondisi_id', 'data_kondisi_id');
    }

    public function stokHasSupplier(){
        return $this->belongsTo(SupplierModels::class, 'data_supplier_id', 'supplier_id');
    }
}
