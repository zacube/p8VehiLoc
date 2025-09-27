<?php

namespace App\Entity;

use App\enum\CarStatus;
use App\Repository\CarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $monthlyPrice = null;

    #[ORM\Column]
    private ?float $dailyRate = null;

    #[ORM\Column]
    private ?int $seats = null;

    #[ORM\Column(length: 255)]
    private ?CarStatus $gearbox = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMonthlyPrice(): ?float
    {
        return $this->monthlyPrice;
    }

    public function setMonthlyPrice(float $monthlyPrice): static
    {
        $this->monthlyPrice = $monthlyPrice;

        return $this;
    }

    public function getDailyRate(): ?float
    {
        return $this->dailyRate;
    }

    public function setDailyRate(float $dailyRate): static
    {
        $this->dailyRate = $dailyRate;

        return $this;
    }

    public function getSeats(): ?int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): static
    {
        $this->seats = $seats;

        return $this;
    }

    public function getGearbox(): ?CarStatus
    {
        return $this->gearbox;
    }

    public function setGearbox(CarStatus $gearbox): static
    {
        $this->gearbox = $gearbox;

        return $this;
    }
}
