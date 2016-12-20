<?php

namespace App\Services;

use LeagueWrap\Api;

class LeagueOfLegendsService
{
    public function __construct($name)
    {
        $api = new Api(getenv("RIOT_API_KEY"));

        $summoner = $api->summoner();
        $championMastery = $api->championmastery();

        $summonerInfo = $summoner->info($name);

        $totalChampionMastery = $championMastery->score($summonerInfo->get('id'));

        $championsWithPoints = count($championMastery->champions($summonerInfo->get('id')));

        $divisionRank = $api->league()->league($summonerInfo->get('id'), true);

        // @todo fix it fix it fix it!
        $summonerData = array_merge(
            $summonerInfo,
            $totalChampionMastery,
            $championsWithPoints,
            $divisionRank
        );

        // @todo connect addtional api endpooints to obtain data for summoners table
    }
}
