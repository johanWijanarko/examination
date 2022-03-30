<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'par_jenis_jabatan';
    protected $primaryKey = 'jenis_jabatan_id';

    protected $fillable = ['jenis_jabatan_id', 'jenis_jabatan_penugasan', 'jenis_jabatan_name', 'jenis_jabatan_kode','jenis_jabatan_sort', 'jenis_jabatan_del_st', 'updated_at', 'created_at'];

    public function jabatan()
    {
        return $this->belongsTo(PegawaiModels::class, 'auditor_id_jabatan', 'jenis_jabatan_id');
    }
}
