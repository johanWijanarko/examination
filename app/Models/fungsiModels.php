<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fungsiModels extends Model
{
    use HasFactory;
    protected $table = 'par_data_fungsi';
    protected $primaryKey = 'data_fungsi_id';

    protected $fillable = ['data_fungsi_id', 'kode_data_fungsi', 'nama_data_fungsi', 'created_at', 'updated_at'];
}
