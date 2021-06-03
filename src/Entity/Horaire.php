<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HoraireRepository::class)
 */
class Horaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jour;

    /**
     * @ORM\Column(type="integer")
     */
    private $heureDebutMatin;

    /**
     * @ORM\Column(type="integer")
     */
    private $heureFinMatin;

    /**
     * @ORM\Column(type="integer")
     */
    private $heureDebutApresMidi;

    /**
     * @ORM\Column(type="integer")
     */
    private $heureFinApresMidi;

    /**
     * @ORM\ManyToMany(targetEntity=Boutique::class, inversedBy="horaires")
     */
    private $boutique;

    public function __construct()
    {
        $this->boutique = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHeureDebutMatin(): ?int
    {
        return $this->heureDebutMatin;
    }

    public function setHeureDebutMatin(int $heureDebutMatin): self
    {
        $this->heureDebutMatin = $heureDebutMatin;

        return $this;
    }

    public function getHeureFinMatin(): ?int
    {
        return $this->heureFinMatin;
    }

    public function setHeureFinMatin(int $heureFinMatin): self
    {
        $this->heureFinMatin = $heureFinMatin;

        return $this;
    }

    public function getHeureDebutApresMidi(): ?int
    {
        return $this->heureDebutApresMidi;
    }

    public function setHeureDebutApresMidi(int $heureDebutApresMidi): self
    {
        $this->heureDebutApresMidi = $heureDebutApresMidi;

        return $this;
    }

    public function getHeureFinApresMidi(): ?int
    {
        return $this->heureFinApresMidi;
    }

    public function setHeureFinApresMidi(int $heureFinApresMidi): self
    {
        $this->heureFinApresMidi = $heureFinApresMidi;

        return $this;
    }

    /**
     * @return Collection|Boutique[]
     */
    public function getBoutique(): Collection
    {
        return $this->boutique;
    }

    public function addBoutique(Boutique $boutique): self
    {
        if (!$this->boutique->contains($boutique)) {
            $this->boutique[] = $boutique;
        }

        return $this;
    }

    public function removeBoutique(Boutique $boutique): self
    {
        $this->boutique->removeElement($boutique);

        return $this;
    }
}
