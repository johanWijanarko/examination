<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMerkModels extends Model
{
    use HasFactory;
    protected $table = 'par_data_merk';
    protected $primaryKey = 'data_merk_id';

    protected $fillable = ['data_merk_id', 'kode_data_merk', 'nama_data_merk', 'created_at', 'updated_at'];
}
