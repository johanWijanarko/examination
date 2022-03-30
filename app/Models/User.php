<?php

namespace App\Models;

use Auth;
use App\Models\PegawaiModels;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, HasRoles;


    public function getCheckRoleUserAttribute()
    {
        // $admin = Auth::user()->hasRole('Admin');
        // $inspektor = Auth::user()->pegawai->auditor_status == 0 && !Auth::user()->hasRole('Admin');
        // $vendor = Auth::user()->pegawai->auditor_status == 1 && !Auth::user()->hasRole('Admin');

        // if ($admin) {
        //     return 'admin';
        // } elseif ($inspektor) {
        //     return 'inspektor';
        // } elseif ($vendor) {
        //     return 'vendor';
        // }
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Anda telah melakukan {$eventName} user";
    }

    public function pegawai()
    {
        return $this->hasOne(PegawaiModels::class, 'pegawai_id', 'user_proyek');
    }

    public function hasAuditors()
    {
        return $this->hasMany(PegawaiModels::class, 'pegawai_id', 'user_internal_id');
    }
    public function auditor()
    {
        return $this->hasOne(PegawaiModels::class, 'pegawai_id', 'user_internal_id');
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function projectHasUser()
    {
        return $this->hasMany('Models\App\UserHasProject');
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_internal_id',
        'user_eksternal_id',
        'login_as',
        'user_foto',
        'session_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
