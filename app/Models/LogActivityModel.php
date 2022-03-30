<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivityModel extends Model
{
    use HasFactory;
    protected $table = 'log_activity';
    protected $primarykey = 'log_id';
    protected $fillable = ['log_subject','log_keterangan','log_user', 'log_url', 'log_data', 'log_ip', 'log_query' , 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($log) {
        $log->log_user = auth()->user()->name;
        $log->log_url = request()->url();
        $log->log_ip = request()->ip();
       });
    }

}
