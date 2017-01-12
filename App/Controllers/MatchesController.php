<?php

namespace App\Controllers;

use App\Services\LeagueOfLegendsService;
use LeagueWrap\Api\Matchlist;
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
        $data = $request->getParsedBody();

        $leagueOfLegendsService = new LeagueOfLegendsService($data['name']);

        $summonerData = $leagueOfLegendsService->getSummonerData();

        $identity = $summonerData['summoner_id'];

        $matchList = $matches->matchlist($identity);

        var_dump($matchList);

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
