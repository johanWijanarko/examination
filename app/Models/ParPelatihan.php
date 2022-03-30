<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParPelatihan extends Model
{
    use HasFactory;
    protected $table = 'auditor_pelatihan';
    protected $primaryKey = 'pelatihan_id';

    protected $fillable = ['pelatihan_id', 'pelatihan_auditor_id', 'pelatihan_kompetensi_id', 'pelatihan_nama', 'pelatihan_durasi', 'pelatihan_tanggal_awal', 'pelatihan_tanggal_akhir', 'pelatihan_penyelenggara', 'pelatihan_sertifikat', 'created_at', 'updated_at'];

    public function jenisPelatihan()
    {
        return $this->hasOne(ParKompetensi::class, 'kompetensi_id', 'pelatihan_id');
    }
}
