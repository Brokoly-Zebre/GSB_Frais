<?php

namespace App\Entity;

use App\Repository\LigneFraisForfaitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneFraisForfaitRepository::class)]
class LigneFraisForfait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantité = null;

    #[ORM\ManyToOne(inversedBy: 'ligneFraisForfait')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FicheFrais $ficheFrais = null;

    #[ORM\ManyToOne(inversedBy: 'fraisForfais')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FraisForfais $fraisForfais = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantité(): ?int
    {
        return $this->quantité;
    }

    public function setQuantité(int $quantité): self
    {
        $this->quantité = $quantité;

        return $this;
    }

    public function getFicheFrais(): ?FicheFrais
    {
        return $this->ficheFrais;
    }

    public function setFicheFrais(?FicheFrais $ficheFrais): self
    {
        $this->ficheFrais = $ficheFrais;

        return $this;
    }

    public function getFraisForfais(): ?FraisForfais
    {
        return $this->fraisForfais;
    }

    public function setFraisForfais(?FraisForfais $fraisForfais): self
    {
        $this->fraisForfais = $fraisForfais;

        return $this;
    }
}
