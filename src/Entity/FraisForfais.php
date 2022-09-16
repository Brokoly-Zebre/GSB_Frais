<?php

namespace App\Entity;

use App\Repository\FraisForfaisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FraisForfaisRepository::class)]
class FraisForfais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $libellé = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $montant = null;

    #[ORM\OneToMany(mappedBy: 'fraisForfais', targetEntity: LigneFraisForfait::class)]
    private Collection $fraisForfais;

    public function __construct()
    {
        $this->fraisForfais = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLibellé(): ?string
    {
        return $this->libellé;
    }

    public function setLibellé(string $libellé): self
    {
        $this->libellé = $libellé;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * @return Collection<int, LigneFraisForfait>
     */
    public function getFraisForfais(): Collection
    {
        return $this->fraisForfais;
    }

    public function addFraisForfai(LigneFraisForfait $fraisForfai): self
    {
        if (!$this->fraisForfais->contains($fraisForfai)) {
            $this->fraisForfais->add($fraisForfai);
            $fraisForfai->setFraisForfais($this);
        }

        return $this;
    }

    public function removeFraisForfai(LigneFraisForfait $fraisForfai): self
    {
        if ($this->fraisForfais->removeElement($fraisForfai)) {
            // set the owning side to null (unless already changed)
            if ($fraisForfai->getFraisForfais() === $this) {
                $fraisForfai->setFraisForfais(null);
            }
        }

        return $this;
    }
}
