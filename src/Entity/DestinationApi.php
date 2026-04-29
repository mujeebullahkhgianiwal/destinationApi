<?php

namespace App\Entity;

use App\Repository\DestinationApiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DestinationApiRepository::class)]
class DestinationApi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private array $activities = [];

    #[ORM\Column]
    private ?int $average_cost = null;

    #[ORM\Column]
    private array $best_travel_months = [];

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

    public function getActivities(): array
    {
        return $this->activities;
    }

    public function setActivities(array $activities): static
    {
        $this->activities = $activities;

        return $this;
    }

    public function getAverageCost(): ?int
    {
        return $this->average_cost;
    }

    public function setAverageCost(int $average_cost): static
    {
        $this->average_cost = $average_cost;

        return $this;
    }

    public function getBestTravelMonths(): array
    {
        return $this->best_travel_months;
    }

    public function setBestTravelMonths(array $best_travel_months): static
    {
        $this->best_travel_months = $best_travel_months;

        return $this;
    }
}
