<?php

namespace App\Controllers;

use App\Models\DivisionRanksModel;
use App\Models\SummonersModel;
use App\Services\LeagueOfLegendsService;
use Zend\Diactoros\ServerRequest;

class SummonersController extends BaseController
{
    /**
     * @return string
     */
    public function create()
    {
        return $this->view->render('summoners.html');
    }

    /**
     * @param ServerRequest $request
     */
    public function store(ServerRequest $request)
    {
        $summoner = new SummonersModel();
        $divisionModel = new DivisionRanksModel();

        $data = $request->getParsedBody();

        $leagueOfLegendsService = new LeagueOfLegendsService($data['name']);

        $division = $divisionModel
            ->where('tier', $leagueOfLegendsService->getSummonerData()['tier'])
            ->where('division', $leagueOfLegendsService->getSummonerData()['division'])
            ->get();

        $dummyData = [
            'summoner_id' => 1,                 // returns with name
            'level' => 30,                      // returns with name
            'total_champion_mastery' => 1337,   // it's own query, by total mastery points
            'main_role_played' => 'Top',        // matchlist, nested array key value 'lane'
            'champions_with_points' => 127,     // query on champions use count($array) to find #
            'player_icon_id' => 255,            // returns with name
            'users_id' => 1,                    // needs to be stored in cache when logged in
            'division_ranks_id' => 1,           // it's own query under League
        ];

        $result = array_merge($dummyData, $data);

        $summoner->fill($result);

        $summoner->save();

        header('Location: http://lol-friend-compare.local/summoners/add');
        exit();
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

    /**
     * @param ServerRequest $request
     * @param $response
     * @param $arguments
     */
    public function destroy(ServerRequest $request, $response, $arguments)
    {
        $summonerModel = new SummonersModel();

        /** @var SummonersModel $summoner */
        $summoner = $summonerModel->find($arguments['id']);

        $summoner->delete();
    }
}
