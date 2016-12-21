<?php

namespace App\Services;

use LeagueWrap\Api;
use LeagueWrap\Dto\League;

class LeagueOfLegendsService
{
    protected $summonerData;

    /**
     * LeagueOfLegendsService constructor.
     * @param $name
     */
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

        $this->summonerData = array_merge(
            $summonerInfo->raw(),
            ['total_champion_mastery' => $totalChampionMastery],
            ['champions_with_points' => $championsWithPoints],
            ['tier' => $divisionRank[0]->get('tier')],
            ['division' => $divisionRank[0]->get('entries')[0]->get('division')]
        );
    }

    /**
     * @return array
     */
    public function getSummonerData()
    {
        return $this->summonerData;
    }
}
