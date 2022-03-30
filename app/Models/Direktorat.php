<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Direktorat extends Model
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'par_direktorat';
    protected $primaryKey = 'direktorat_id';

    protected $fillable = ['direktorat_id', 'direktorat_name', 'direktorat_del_st', 'created_at', 'updated_at'];

    public function auditee()
    {
        return $this->belongsTo(AuditeeModel::class, 'auditee_direktorat_id', 'direktorat_id');
    }
}
