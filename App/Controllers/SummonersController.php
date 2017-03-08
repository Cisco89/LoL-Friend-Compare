<?php

namespace App\Controllers;

use App\Models\DivisionRanksModel;
use App\Models\MatchesModel;
use App\Models\SummonersModel;
use App\Models\UsersModel;
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
        //* @todo The summoner model is being instantiated x 2 in this controller can be done better
        $summonerModel          = new SummonersModel();
        $divisionModel          = new DivisionRanksModel();
        $leagueOfLegendsService = new LeagueOfLegendsService();
        $matchesModel           = new MatchesModel();
        $userModel              = new UsersModel();

        $user = $userModel->find($_SESSION['user']['id']);

        $data = $request->getParsedBody();

        $summonerData = $leagueOfLegendsService->getSummonerData($data['name']);

        $division = $divisionModel
            ->where('tier', $summonerData['tier'])
            ->where('division', $summonerData['division'])
            ->get();

        unset( $summonerData['tier'], $summonerData['division']);

        //* @todo couldn't I remove the whole line below and just place it on the get method?
        $divisionId = intval($division->first()->getAttributes()['id']);

        // @todo replace lane with actual aggregated data
        $matchList = $leagueOfLegendsService->matchlist($summonerData['summoner_id']);

        $result = array_merge(
            ['main_role_played' => $matchList->raw()['matches'][0]['lane']],
            $summonerData,
            ['division_ranks_id' => $divisionId]);

        $summonerModel->fill($result);

        if ($summonerModel->save()) {

            $user->summoners()->attach($summonerModel->getAttribute('id'));

            $matchesArray = $leagueOfLegendsService->getMatchlist($summonerModel['summoner_id']);

            $matchesModel->insert($matchesArray);

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
