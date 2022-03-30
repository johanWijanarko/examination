<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GedungModels extends Model
{
    use HasFactory;
    protected $table = 'par_gedung';
    protected $primaryKey = 'data_gedung_id';

    protected $fillable = ['data_gedung_id', 'kode_data_gedung', 'nama_data_gedung', 'created_at', 'updated_at'];
}
