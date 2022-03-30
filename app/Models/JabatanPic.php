<?php

namespace App\Models;

use App\Http\Controllers\PejabatAuditee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanPic extends Model
{
    use HasFactory;

    protected $table = 'par_jabatan_pic';
    protected $primaryKey = 'jabatan_pic_id';

    protected $fillable = ['jabatan_pic_id', 'jabatan_pic_name', 'jabatan_pic_short', 'jabatan_pic_del_st', 'jenis_jabatan_del_st', 'created_at', 'updated_at'];

    public function auditee_pic()
    {
        return $this->belongsTo(PejabatAuditee::class, 'pic_jabatan_id', 'jabatan_pic_id');
    }
}
