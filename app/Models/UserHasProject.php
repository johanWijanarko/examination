<?php

namespace App\Models;

use App\Models\User;
// use App\Models\Pegawai;
use App\Models\Inspeksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserHasProject extends Model
{
    use HasFactory;
    protected $table = 'auditee_pic';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'pic_id';

    public function inspeksi()
    {

        return $this->hasMany(Inspeksi::class, 'nama_project', 'pic_id');
    }
    public function insepksijenis()
    {
        return $this->belongsTo(JenisProyek::class, 'pic_jenis', 'jenis_id');
    }
}
