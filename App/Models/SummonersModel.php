<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SummonersModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'summoners';
    
    protected $fillable = [
        'name',
        'summoner_id',  
        'level',  
        'total_champion_mastery',
        'main_role_played',
        'champions_owned',
        'player_icon_id',
        'users_id',
        'division_ranks_id',
    ];


}
