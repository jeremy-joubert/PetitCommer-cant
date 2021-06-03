<?php

namespace App\Entity;

use App\Repository\BoutiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoutiqueRepository::class)
 */
class Boutique
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Horaire::class, mappedBy="boutique")
     */
    private $horaires;

    /**
     * @ORM\ManyToMany(targetEntity=CategorieBoutique::class, mappedBy="boutique")
     */
    private $categorieBoutiques;

    /**
     * @ORM\OneToMany(targetEntity=Commercant::class, mappedBy="boutique")
     */
    private $commercants;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="boutique")
     */
    private $images;

    public function __construct()
    {
        $this->horaires = new ArrayCollection();
        $this->categorieBoutiques = new ArrayCollection();
        $this->commercants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Horaire[]
     */
    public function getHoraires(): Collection
    {
        return $this->horaires;
    }

    public function addHoraire(Horaire $horaire): self
    {
        if (!$this->horaires->contains($horaire)) {
            $this->horaires[] = $horaire;
            $horaire->addBoutique($this);
        }

        return $this;
    }

    public function removeHoraire(Horaire $horaire): self
    {
        if ($this->horaires->removeElement($horaire)) {
            $horaire->removeBoutique($this);
        }

        return $this;
    }

    /**
     * @return Collection|CategorieBoutique[]
     */
    public function getCategorieBoutiques(): Collection
    {
        return $this->categorieBoutiques;
    }

    public function addCategorieBoutique(CategorieBoutique $categorieBoutique): self
    {
        if (!$this->categorieBoutiques->contains($categorieBoutique)) {
            $this->categorieBoutiques[] = $categorieBoutique;
            $categorieBoutique->addBoutique($this);
        }

        return $this;
    }

    public function removeCategorieBoutique(CategorieBoutique $categorieBoutique): self
    {
        if ($this->categorieBoutiques->removeElement($categorieBoutique)) {
            $categorieBoutique->removeBoutique($this);
        }

        return $this;
    }

    /**
     * @return Collection|Commercant[]
     */
    public function getCommercants(): Collection
    {
        return $this->commercants;
    }

    public function addCommercant(Commercant $commercant): self
    {
        if (!$this->commercants->contains($commercant)) {
            $this->commercants[] = $commercant;
            $commercant->setBoutique($this);
        }

        return $this;
    }

    public function removeCommercant(Commercant $commercant): self
    {
        if ($this->commercants->removeElement($commercant)) {
            // set the owning side to null (unless already changed)
            if ($commercant->getBoutique() === $this) {
                $commercant->setBoutique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function getImage()
    {
        return $this->images[0];
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setBoutique($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getBoutique() === $this) {
                $image->setBoutique(null);
            }
        }

        return $this;
    }
}
