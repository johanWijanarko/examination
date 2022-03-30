<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
    protected $table = 'par_kabupaten';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'province_id', 'name', 'created_at', 'updated_at'];
    public function auditee()
    {
        return $this->belongsTo(AuditeeModel::class, 'auditee_kabupaten_id', 'id');
    }
}
