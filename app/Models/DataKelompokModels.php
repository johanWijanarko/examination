<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKelompokModels extends Model
{
    use HasFactory;
    protected $table = 'par_data_kelompok';
    protected $primaryKey = 'data_kelompok_id';

    protected $fillable = ['data_kelompok_id', 'kode_data_kelompok', 'nama_data_kelompok', 'created_at', 'updated_at'];
}
