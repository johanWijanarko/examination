<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParPendidikan extends Model
{
    use HasFactory;
    protected $table = 'auditor_pendidikan';
    protected $primaryKey = 'pendidikan_id';

    protected $fillable = ['pendidikan_id', 'pendidikan_auditor_id', 'pendidikan_tingkat', 'pendidikan_institusi', 'pendidikan_kota', 'pendidikan_negara', 'pendidikan_tahun', 'pendidikan_jurusan', 'pendidikan_nilai', 'created_at', 'updated_at'];
}
