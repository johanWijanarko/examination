<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinsiModels extends Model
{
    use HasFactory;
    protected $table = 'par_provinsi';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
}
