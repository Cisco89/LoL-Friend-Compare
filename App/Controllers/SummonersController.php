<?php

namespace App\Controllers;

use App\Models\DivisionRanksModel;
use App\Models\MatchesModel;
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
        $matches = new MatchesModel();

        $data = $request->getParsedBody();

        $leagueOfLegendsService = new LeagueOfLegendsService();

        $summonerData = $leagueOfLegendsService->getSummonerData($data['name']);

        $division = $divisionModel
            ->where('tier', $summonerData['tier'])
            ->where('division', $summonerData['division'])
            ->get();

        unset( $summonerData['tier'], $summonerData['division']);

        $divisionId = intval($division->first()->getAttributes()['id']);

        // @todo replace lane with actual aggregated data
        $matchList = $leagueOfLegendsService->matchlist($summonerData['summoner_id']);

        $result = array_merge(
            ['main_role_played' => $matchList->raw()['matches'][0]['lane']],
            $summonerData,
            ['division_ranks_id' => $divisionId]);
        $result['users_id'] = $_SESSION['user']['id'];

        $summoner->fill($result);

        if ($summoner->save()) {

            //* @todo somehow convert the negative row insert into matches table
            for ($matchIndex = $matchList->raw()['startIndex'];
                $matchIndex  < $matchList->raw()['endIndex'];
                $matchIndex++) {

                $match = $matchList->raw()['matches'][$matchIndex];
                $match['summoner_id']   = intval($summoner->getAttributes()['summoner_id']);
                $match['match_id']      = (string) $match['matchId'];
                $match['lane']          = ucfirst(strtolower($match['lane']));

                unset(
                    $match['region'],
                    $match['matchId'],
                    $match['platformId'],
                    $match['champion'],
                    $match['queue'],
                    $match['season'],
                    $match['timestamp'],
                    $match['role']
                );

                $matches->create($match);
            }

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
