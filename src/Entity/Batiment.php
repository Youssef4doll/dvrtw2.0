<?php

namespace App\Entity;

use App\Repository\BatimentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BatimentRepository::class)]
class Batiment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $nbetage = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateconstruction = null;

    #[ORM\Column(length: 255)]
    private ?string $disponible = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getNbetage(): ?int
    {
        return $this->nbetage;
    }

    public function setNbetage(int $nbetage): static
    {
        $this->nbetage = $nbetage;
        return $this;
    }

    public function getDateconstruction(): ?\DateTimeInterface
    {
        return $this->dateconstruction;
    }

    public function setDateconstruction(\DateTimeInterface $dateconstruction): static
    {
        $this->dateconstruction = $dateconstruction;
        return $this;
    }

    public function getDisponible(): ?string
    {
        return $this->disponible;
    }

    public function setDisponible(string $disponible): static
    {
        $this->disponible = $disponible;
        return $this;
    }
}
