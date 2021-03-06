<?php

namespace App\Entity;

class Team
{
    private string $name;
    private string $country;
    private string $logo;
    /**
     * @var Player[] 
     */
    private array $players;
    private string $coach;
    private int $goals;


    public function __construct(string $name, string $country, string $logo, array $players, string $coach)
    {
        $this->assertCorrectPlayers($players);

        $this->name = $name;
        $this->country = $country;
        $this->logo = $logo;
        $this->players = $players;
        $this->coach = $coach;
        $this->goals = 0;
        $this->postime=[];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLogo(): string
    {
        return $this->logo;
    

    /**
     * @return Player[]
     */
    }
    public function getPlayersOnField(): array
    {
        return array_filter($this->players, function (Player $player) {
            return $player->isPlay();
        });
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPlayer(int $number): Player
    {
        foreach ($this->players as $player) {
            if ($player->getNumber() === $number) {
                return $player;
            }
        }

        throw new \Exception(
            sprintf(
                'Player with number "%d" not play in team "%s".',
                $number,
                $this->name
            )
        );
    }


    public function getCoach(): string
    {
        return $this->coach;
    }

    public function addGoal(): void
    {
        $this->goals += 1;
    }

    public function getGoals(): int
    {
        return $this->goals;
    }


    private function assertCorrectPlayers(array $players)
    {
        foreach ($players as $player) {
            if (!($player instanceof Player)) {
                throw new \Exception(
                    sprintf(
                        'Player should be instance of "%s". "%s" given.',
                        Player::class,
                        get_class($player)
                    )
                );
            }
        }
    }


    // эту функцию я написал
    public function getPosTime(String $position): int
    {
        $timepos=0;
        foreach ($this->players as $player) {
            if ($player->getPosition() == $position) {
                $timepos=$timepos+$player->getPlayTime();
            }
        }
        return $timepos;
    }

    public function makePosTimeArray(): void
    {
        $postime=[];
        $key1="нападающие";
        $key2="полузащитники";
        $key3="защитники";
        $key4="вратари";
        $postime[$key1] = $this->getPosTime("Н");
        $postime[$key2] = $this->getPosTime("П");
        $postime[$key3] = $this->getPosTime("З");
        $postime[$key4] = $this->getPosTime("В");

        $this->postime=$postime;
    }


}