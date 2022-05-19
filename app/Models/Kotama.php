<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kotama extends Model
{
    use HasFactory;
    protected $table = 'tb_kotama';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'kode_kotama', 'nama_kotama', 'del_st_kotama', 'created_at', 'updated_at'];
}
