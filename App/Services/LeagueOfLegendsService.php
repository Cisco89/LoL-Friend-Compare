<?php

namespace App\Services;

use LeagueWrap\Api;

class LeagueOfLegendsService
{
    public function __construct($name)
    {
        $api = new Api(getenv("RIOT_API_KEY"));

        $summoner = $api->summoner();

        $data = $summoner->info($name);

        // @todo connect addtional api endpooints to obtain data for summoners table
    }
}
