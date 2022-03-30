<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParTahunModel extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'par_tahun';
    protected $primaryKey = 'id_tahun';
    protected $fillable = ['id_tahun', 'nama', 'status', 'created_at', 'updated_at'];
}
