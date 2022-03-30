<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Divisi extends Model
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'par_pangkat_auditor';
    protected $primaryKey = 'pangkat_id';

    protected $fillable = ['pangkat_id', 'pangkat_name', 'pangkat_desc', 'pangkat_del_st', 'created_at', 'updated_at'];

    public function auditors()
    {
        return $this->belongsTo(PegawaiModels::class, 'pangkat_id', 'auditor_id_pangkat');
    }
}
