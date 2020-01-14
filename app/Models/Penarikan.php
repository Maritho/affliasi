<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penarikan extends Model
{
    protected $primaryKey = 'id_penarikan';
    public $timestamps = false;
    protected $dates = ['created_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'user_id');
    }
}
