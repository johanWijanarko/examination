<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExam extends Model
{
    use HasFactory;
    protected $table = 'user_exam';
    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'pertanyaan_id', 'pertanyaan', 'jawaban', 'jawaban_detail','created_at', 'updated_at'];

}
