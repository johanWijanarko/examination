<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanModel extends Model
{
    use HasFactory;
    protected $table = 'jawaban';
    protected $primaryKey = 'id';
    protected $fillable = ['pertanyaan_id', 'jawaban_a', 'jawaban_b','jawaban_c', 'jawaban_d', 'jawaban_e','created_at', 'updated_at'];

    public function hasPertanyaan(){
        return $this->PertanyaanModel(User::class, 'pertanyaan_id', 'id');
    }
}
