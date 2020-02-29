<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RiderInTeamRepository")
 */
class RiderInTeam
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $rider_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $team_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRiderId(): ?int
    {
        return $this->rider_id;
    }

    public function setRiderId(int $rider_id): self
    {
        $this->rider_id = $rider_id;

        return $this;
    }

    public function getTeamId(): ?int
    {
        return $this->team_id;
    }

    public function setTeamId(int $team_id): self
    {
        $this->team_id = $team_id;

        return $this;
    }
}
