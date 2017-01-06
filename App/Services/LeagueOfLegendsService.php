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

        $summonerInfo = $summoner->info($name)->raw();

        $summonerArray = [];
        $summonerArray['summoner_id']       = $summonerInfo['id'];
        $summonerArray['name']              = $summonerInfo['name'];
        $summonerArray['player_icon_id']    = $summonerInfo['profileIconId'];
        $summonerArray['level']             = $summonerInfo['summonerLevel'];

        $totalChampionMastery = $championMastery->score($summonerInfo['id']);

        $championsWithPoints = count($championMastery->champions($summonerInfo['id']));

        $divisionRank = $api->league()->league($summonerInfo['id'], true);

        $this->summonerData = array_merge(
            $summonerArray,
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
