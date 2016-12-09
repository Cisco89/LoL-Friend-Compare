<?php

namespace App\Controllers;

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

        $data = $request->getParsedBody();

        $leagueOfLegendsService = new LeagueOfLegendsService($data['name']);

        $dummyData = [
            'summoner_id' => 1,
            'level' => 30,
            'total_champion_mastery' => 1337,
            'main_role_played' => 'Top',
            'champions_owned' => 127,
            'player_icon_id' => 255,
            'users_id' => 1,
            'division_ranks_id' => 1,
        ];

        $result = array_merge($data, $dummyData);

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
