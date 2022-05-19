<?php

namespace App\Models;

use App\Models\JawabanModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PertanyaanModel extends Model
{
    use HasFactory;
    protected $table = 'pertanyaan';
    protected $primaryKey = 'id';
    protected $fillable = ['pertanyaan', 'jawaban', 'bobot','created_at', 'updated_at'];

    public function PertanyanHasJawaban(){
        return $this->hasMany(JawabanModel::class, 'pertanyaan_id', 'id');
        // return $this->hasMany(DetailTransaksi::class, 'trs_id', 'trs_id');
    }

}
