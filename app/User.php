<?php

namespace App;

use Laravel\Cashier\Billable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'motto', 'username', 'password', 'banned',
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

    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * @return mixed
     */
    public function bans()
    {
        return $this->belongsToMany('App\Ban');
    }

    /**
     * @return bool
     */
    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return null !== $this->roles()->whereIn('name', $roles)->first();
        }
        return null !== $this->roles()->where('name', $roles)->first();
    }

    /**
     * @return bool
     */
    public function isBanned()
    {
        return boolval($this->banned);
    }

    /**
     * $return bool
     */
    public function hasBanType($types)
    {
        if (is_array($types)) {
            return null !== $this->bans()->whereIn('type', $types)->first();
        }
        return null !== $this->bans()->where('type', $types)->first();
    }
}
