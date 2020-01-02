<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $primaryKey = 'id_user';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * appends attribute pendapatan
     * @var array
     */
    public $appends = ['pendapatan', 'role'];

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * set value pendapatan
     */
    public function getPendapatanAttribute()
    {
        $user_id = Arr::get($this, 'id');
        return (integer) Transaction::where('user_id', $user_id)->where('status', 1)->sum('komisi');
    }

    public function getRoleAttribute() {
        $role_id = Arr::get($this->attributes, 'id_role');
        return Role::where('id_role', $role_id)->first();
    }
}
