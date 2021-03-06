<?php

namespace App\Services;

use LeagueWrap\Api;
use LeagueWrap\Api\Matchlist;

class LeagueOfLegendsService
{
    protected $summonerData;

    protected $api;

    /**
     * LeagueOfLegendsService constructor.
     */
    public function __construct()
    {
        $this->api = new Api(getenv("RIOT_API_KEY"));


    }

    /**
     * @param $name
     * @return array
     */
    public function getSummonerData($name)
    {
        $summoner = $this->api->summoner();
        $championMastery = $this->api->championmastery();

        $summonerInfo = $summoner->info($name)->raw();

        $summonerArray = [];
        $summonerArray['summoner_id']       = $summonerInfo['id'];
        $summonerArray['name']              = $summonerInfo['name'];
        $summonerArray['player_icon_id']    = $summonerInfo['profileIconId'];
        $summonerArray['level']             = $summonerInfo['summonerLevel'];

        $totalChampionMastery = $championMastery->score($summonerInfo['id']);

        $championsWithPoints = count($championMastery->champions($summonerInfo['id']));

        // @todo catch exemptions
        $divisionRank = $this->api->league()->league($summonerInfo['id'], true);

        $this->summonerData = array_merge(
            $summonerArray,
            ['total_champion_mastery' => $totalChampionMastery],
            ['champions_with_points' => $championsWithPoints],
            ['tier' => $divisionRank[0]->get('tier')],
            ['division' => $divisionRank[0]->get('entries')[0]->get('division')]
        );
        return $this->summonerData;
    }

    /**
     * @param $summonerId
     * @return MatchList
     */
    public function matchlist($summonerId)
    {
        /** @var MatchList $matchlistApi */
        $matchlistApi = $this->api->matchlist($summonerId);
        $matchlist    = $matchlistApi->matchlist($summonerId);

        return $matchlist;

    }

    /**
     * @param $summonerId
     * @return array
     */
    public function getMatchlist($summonerId)
    {
        $matchArray = [];

        $matchList = $this->matchlist($summonerId);

        for ($matchIndex = $matchList->raw()['startIndex'];
             $matchIndex < $matchList->raw()['endIndex'];
             $matchIndex++) {

            $match = $matchList->raw()['matches'][$matchIndex];

            $matchArray[] = [
                'match_id'      => (string)$match['matchId'],
                'lane'          => ucfirst(strtolower($match['lane'])),
                'role'          => $match['role'],
                'summoner_id'   => $summonerId
            ];
        }

        return $matchArray;
    }
}
