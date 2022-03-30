<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParUnitSpiModel extends Model
{
    use HasFactory;
    protected $table = 'par_unit_spi';
    protected $primaryKey = 'unit_spi_id';

    protected $fillable = ['unit_spi_id', 'unit_spi_nama', 'unit_spi_del_st',  'created_at', 'updated_at'];
}
