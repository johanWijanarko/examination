<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiModels extends Model
{
    use HasFactory;
    protected $table = 'par_kondisi';
    protected $primaryKey = 'data_kondisi_id';

    protected $fillable = ['data_kondisi_id', 'kode_data_kondisi', 'nama_data_kondisi', 'created_at', 'updated_at'];
}
