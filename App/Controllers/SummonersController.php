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
     * @var SummonersModel
     */
    private $summonerModel;

    /**
     * @var UsersModel
     */
    private $userModel;

    /**
     * SummonersController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->summonerModel = new SummonersModel();

        $this->userModel = new UsersModel();
    }

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
        $divisionModel          = new DivisionRanksModel();
        $leagueOfLegendsService = new LeagueOfLegendsService();
        $matchesModel           = new MatchesModel();

        $user = $this->userModel->find($_SESSION['user']['id']);

        $data = $request->getParsedBody();

        $summonerData = $leagueOfLegendsService->getSummonerData($data['name']);

        $summoner = $this->summonerModel->where('summoner_id', '=', $summonerData['summoner_id'])->first();
        if (!$summoner) {

            $division = $divisionModel
                ->where('tier', $summonerData['tier'])
                ->where('division', $summonerData['division'])
                ->get();

            unset($summonerData['tier'], $summonerData['division']);

            //* @todo couldn't I remove the whole line below and just place it on the get method?
            $divisionId = intval($division->first()->getAttributes()['id']);

            // @todo replace lane with actual aggregated data
            $matchList = $leagueOfLegendsService->matchlist($summonerData['summoner_id']);

            $result = array_merge(
                ['main_role_played' => $matchList->raw()['matches'][0]['lane']],
                $summonerData,
                ['division_ranks_id' => $divisionId]);

            $this->summonerModel->fill($result);


            if ($this->summonerModel->save()) {

                $matchesArray = $leagueOfLegendsService->getMatchlist($this->summonerModel['summoner_id']);

                $matchesModel->insert($matchesArray);
            }

        }

        $this->summonerModel = $summoner ? $summoner : $this->summonerModel;

        $user->summoners()->attach($this->summonerModel->getAttribute('id'));

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
        $user = $this->userModel->find($_SESSION['user']['id']);

        $user->summoners()->detach($this->summonerModel->getAttribute($arguments['id']));
    }
}
