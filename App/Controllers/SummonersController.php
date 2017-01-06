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

        $summonerData = $leagueOfLegendsService->getSummonerData();

        unset( $summonerData['tier'], $summonerData['division']);

        $divisionId = intval($division->first()->getAttributes()['id']);

        // @todo replace dummy data with adequate data
        $dummyData = [
            'main_role_played' => 'Top',        // matchlist, nested array key value 'lane'
            'users_id' => 1,                    // needs to be stored in cache when logged in
        ];

        $result = array_merge($dummyData, $summonerData, ['division_ranks_id' => $divisionId]);

        $summoner->fill($result);

        if ($summoner->save()) {
            header('Location: http://lol-friend-compare.local/summoners/add');
        }

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
