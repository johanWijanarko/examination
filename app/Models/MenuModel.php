<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nama_menu', 'level_menu', 'master_menu', 'url',
'icon', 'permission', 'no_urut', 'status', 'created_at', 'updated_at'];

 public function children()
    {
        return $this->hasMany(MenuModel::class, 'master_menu','id')->where('status',1);
    }
    public function parent()
    {
        return $this->belongsTo(MenuModel::class, 'id', 'master_menu');
    }
}
