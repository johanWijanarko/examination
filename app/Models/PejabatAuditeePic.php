<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PejabatAuditeePic extends Model
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'auditee_pic';
    protected $primaryKey = 'pic_id';
    protected $fillable = ['pic_id', 'pic_nip', 'pic_name', 'pic_jabatan_id', 'pic_telp', 'pic_email', 'pic_auditee_id', 'pic_del_st', 'created_at', 'updated_at'];

    public function jabatan_pic()
    {
        return $this->hasOne(JabatanPic::class, 'jabatan_pic_id', 'pic_jabatan_id');
    }
}
