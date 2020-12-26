<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Gstt\Achievements\Achiever;

class User extends Authenticatable
{
    use Notifiable;
    use Achiever;
    use \Lab404\Impersonate\Models\Impersonate;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin() {
        return $this->type === self::ADMIN_TYPE;
    }
    public function canImpersonate()
    {
        return $this->isAdmin() === true;
    }
    public function canBeImpersonated()
    {
        return !$this->isAdmin() === true;
    }

}
