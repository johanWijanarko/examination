<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeKtegoryModels extends Model
{
    use HasFactory;
    protected $table = 'par_data_type';
    protected $primaryKey = 'data_type_id';

    protected $fillable = ['data_type_id', 'kode_data_type', 'nama_data_type', 'created_at', 'updated_at'];
}
