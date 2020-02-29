<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransferRepository")
 */
class Transfer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $from_team;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $to_team;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=0)
     */
    private $cost;

    /**
     * @ORM\Column(type="integer")
     */
    private $rider_id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $rider_name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $rider_surname;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromTeam(): ?string
    {
        return $this->from_team;
    }

    public function setFromTeam(string $from_team): self
    {
        $this->from_team = $from_team;

        return $this;
    }

    public function getToTeam(): ?string
    {
        return $this->to_team;
    }

    public function setToTeam(string $to_team): self
    {
        $this->to_team = $to_team;

        return $this;
    }

    public function getCost(): ?string
    {
        return $this->cost;
    }

    public function setCost(string $cost): self
    {
        $this->cost = $cost;

        return $this;
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

    public function getRiderName(): ?string
    {
        return $this->rider_name;
    }

    public function setRiderName(string $rider_name): self
    {
        $this->rider_name = $rider_name;

        return $this;
    }

    public function getRiderSurname(): ?string
    {
        return $this->rider_surname;
    }

    public function setRiderSurname(string $rider_surname): self
    {
        $this->rider_surname = $rider_surname;

        return $this;
    }
}
