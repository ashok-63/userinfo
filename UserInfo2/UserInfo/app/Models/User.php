<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection= 'mysql6';
    public $table="login";
    public $timestamps=false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'User_Name', //--From Loginmater tbl
        'Password',//--From Loginmater tbl
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        // 'Password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];

    public function getAuthIdentifierName()
    {
        return 'User_Name';//--From Loginmater tbl
    }

    public function getAuthIdentifier()
    {
        return request()->get('User_Name');
    }

    public function getAuthPassword()
    {
        return Hash::make(request()->get('Password'));
    }
}
