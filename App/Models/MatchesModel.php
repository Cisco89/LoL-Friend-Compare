<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchesModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'matches';

    protected $fillable = [
        'match_id',
        'lane',
        'summoner_id',
        'role',
    ];
}
