<?php

namespace App\Controllers;

use App\Models\SummonersModel;
use App\Services\LeagueOfLegendsService;
use Zend\Diactoros\ServerRequest;

class MatchesController extends BaseController
{
    public function create()
    {

    }

    /**
     * @param ServerRequest $request
     */
    public function store(ServerRequest $request)
    {
        $matches = new SummonersModel();
        $data = $request->getParsedBody();

        $leagueOfLegendsService = new LeagueOfLegendsService();

        $summonerData = $leagueOfLegendsService->getSummonerData($data['name']);

        $matchList = $leagueOfLegendsService->matchlist($summonerData['summoner_id']);

        //* @todo might need to unset('region', 'platformId', 'champion', 'queue', 'season', 'timestamp', 'role')
        for ($matchIndex = $matchList->raw()['matches']['startIndex'];
             $matchIndex <= $matchList->raw()['matches']['endIndex'];
             $matchIndex++) {

            $result = $matchList->raw()['matches'][$matchIndex];

            $result['summoner_id'] = $summonerData['summoner_id'];

            $matches->fill($result);
        }



    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
