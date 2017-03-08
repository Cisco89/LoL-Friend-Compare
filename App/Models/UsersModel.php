<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

class UsersModel extends EloquentUser
{
    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
    ];

    /**
     * @var array
     */
    protected $loginNames = ['username', 'email'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function summoners()
    {
        return $this->belongsToMany(SummonersModel::class, 'user_summoners','users_id', 'summoners_id');
    }
}
