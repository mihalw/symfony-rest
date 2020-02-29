<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StadiumRepository")
 */
class Stadium
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_of_seats;

    /**
     * @ORM\Version @ORM\Column(type="integer", nullable=true)
     */
    private $version;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getNumberOfSeats(): ?int
    {
        return $this->number_of_seats;
    }

    public function setNumberOfSeats(int $number_of_seats): self
    {
        $this->number_of_seats = $number_of_seats;

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(?int $version): self
    {
        $this->version = $version;

        return $this;
    }
}
