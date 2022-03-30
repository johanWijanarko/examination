<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuanganModels extends Model
{
    use HasFactory;
    protected $table = 'par_ruangan';
    protected $primaryKey = 'data_ruangan_id';
    protected $fillable = ['data_ruangan_id', 'kode_data_ruangan', 'nama_data_ruangan','created_at', 'updated_at'];
}
