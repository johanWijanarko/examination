<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParKompetensi extends Model
{
    use HasFactory;
    protected $table = 'par_kompetensi';
    protected $primaryKey = 'kompetensi_id';

    protected $fillable = ['kompetensi_id', 'kompetensi_name', 'kompetensi_desc', 'kompetensi_del_st', 'created_at', 'updated_at'];

    public function pelatihan()
    {
        return $this->belongsTo(ParPelatihan::class, 'pelatihan_id', 'kompetensi_id');
    }
}
