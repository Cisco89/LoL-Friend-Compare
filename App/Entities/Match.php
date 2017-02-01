<?php

namespace App\Entities;

use Illuminate\Contracts\Support\Arrayable;

class Match implements Arrayable
{
    /**
     * @var
     */
    private $matchId;

    /**
     * @var
     */
    private $lane;

    /**
     * @var
     */
    private $role;

    /**
     * @var
     */
    private $victory;

    /**
     * @var
     */
    private $summonerId;

    /**
     * Match constructor.
     * @param string $matchId
     * @param string $lane
     * @param string $role
     * @param int $summonerId
     */
    public function __construct(
        $matchId,
        $lane,
        $role,
        $summonerId
    )
    {
        $this->matchId      = $matchId;
        $this->lane         = $lane;
        $this->role         = $role;
        $this->summonerId   = $summonerId;
    }

    /**
     * @return mixed
     */
    public function getMatchId()
    {
        return $this->matchId;
    }

    /**
     * @return mixed
     */
    public function getLane()
    {
        return $this->lane;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getVictory()
    {
        return $this->victory;
    }

    /**
     * @return mixed
     */
    public function getSummonerId()
    {
        return $this->summonerId;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'match_id'      => $this->matchId,
            'lane'          => $this->lane,
            'role'          => $this->role,
            'summoner_id'   => $this->summonerId,
        ];
    }
}

