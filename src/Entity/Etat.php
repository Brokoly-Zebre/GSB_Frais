<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatRepository::class)]
class Etat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToOne(mappedBy: 'Etat', cascade: ['persist', 'remove'])]
    private ?FicheFrais $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getEtat(): ?FicheFrais
    {
        return $this->etat;
    }

    public function setEtat(FicheFrais $etat): self
    {
        // set the owning side of the relation if necessary
        if ($etat->getEtat() !== $this) {
            $etat->setEtat($this);
        }

        $this->etat = $etat;

        return $this;
    }
}
