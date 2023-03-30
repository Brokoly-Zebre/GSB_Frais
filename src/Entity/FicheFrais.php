<?php

namespace App\Entity;

use App\Repository\FicheFraisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FicheFraisRepository::class)]
class FicheFrais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbjustificatifs = null;



    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateModif = null;

    #[ORM\Column(length: 255)]
    private ?string $mois = null;


    #[ORM\ManyToOne(inversedBy: 'ficheFrais')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'ficheFrais', targetEntity: LigneFraisForfait::class, fetch: 'EAGER')]
    private Collection $ligneFraisForfait;

    #[ORM\OneToMany(mappedBy: 'ficheFrais', targetEntity: LigneFraisHorsForfait::class, orphanRemoval: true, fetch:'EAGER')]
    private Collection $ligneHorsForfait;


    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $montantValid = null;

    #[ORM\ManyToOne(inversedBy: 'fichesFrais')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;


    public function __construct()
    {
        $this->ligneFraisForfait = new ArrayCollection();
        $this->ligneHorsForfait = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbjustificatifs(): ?int
    {
        return $this->nbjustificatifs;
    }

    public function setNbjustificatifs(int $nbjustificatifs): self
    {
        $this->nbjustificatifs = $nbjustificatifs;

        return $this;
    }



    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->dateModif;
    }

    public function setDateModif(\DateTimeInterface $dateModif): self
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): self
    {
        $this->mois = $mois;

        return $this;
    }



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, LigneFraisForfait>
     */
    public function getLigneFraisForfait(): Collection
    {
        return $this->ligneFraisForfait;
    }

    public function addLigneFraisForfait(LigneFraisForfait $ligneFraisForfait): self
    {
        if (!$this->ligneFraisForfait->contains($ligneFraisForfait)) {
            $this->ligneFraisForfait->add($ligneFraisForfait);
            $ligneFraisForfait->setFicheFrais($this);
        }

        return $this;
    }

    public function removeLigneFraisForfait(LigneFraisForfait $ligneFraisForfait): self
    {
        if ($this->ligneFraisForfait->removeElement($ligneFraisForfait)) {
            // set the owning side to null (unless already changed)
            if ($ligneFraisForfait->getFicheFrais() === $this) {
                $ligneFraisForfait->setFicheFrais(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LigneFraisHorsForfait>
     */
    public function getLigneHorsForfait(): Collection
    {
        return $this->ligneHorsForfait;
    }

    public function addLigneHorsForfait(LigneFraisHorsForfait $ligneHorsForfait): self
    {
        if (!$this->ligneHorsForfait->contains($ligneHorsForfait)) {
            $this->ligneHorsForfait->add($ligneHorsForfait);
            $ligneHorsForfait->setFicheFrais($this);
        }

        return $this;
    }

    public function removeLigneHorsForfait(LigneFraisHorsForfait $ligneHorsForfait): self
    {
        if ($this->ligneHorsForfait->removeElement($ligneHorsForfait)) {
            // set the owning side to null (unless already changed)
            if ($ligneHorsForfait->getFicheFrais() === $this) {
                $ligneHorsForfait->setFicheFrais(null);
            }
        }

        return $this;
    }


    public function getMontantValid(): ?string
    {
        return $this->montantValid;
    }

    public function setMontantValid(string $montantValid): self
    {
        $this->montantValid = $montantValid;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }



}
