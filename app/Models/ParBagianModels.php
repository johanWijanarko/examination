<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParBagianModels extends Model
{
    use HasFactory;
    protected $table = 'par_bagian';
    protected $primaryKey = 'bagian_id';
    protected $fillable = ['bagian_id', 'kode_bagian', 'nama_bagian','created_at', 'updated_at'];
}
