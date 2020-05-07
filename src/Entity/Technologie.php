<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TechnologieRepository")
 */
class Technologie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomTechno;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ouvrage", mappedBy="technologie")
     */
    private $ouvrages;

    public function __construct()
    {
        $this->ouvrages = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nomTechno;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTechno(): ?string
    {
        return $this->nomTechno;
    }

    public function setNomTechno(string $nomTechno): self
    {
        $this->nomTechno = $nomTechno;

        return $this;
    }

    /**
     * @return Collection|Ouvrage[]
     */
    public function getOuvrages(): Collection
    {
        return $this->ouvrages;
    }

    public function addOuvrage(Ouvrage $ouvrage): self
    {
        if (!$this->ouvrages->contains($ouvrage)) {
            $this->ouvrages[] = $ouvrage;
            $ouvrage->setTechnologie($this);
        }

        return $this;
    }

    public function removeOuvrage(Ouvrage $ouvrage): self
    {
        if ($this->ouvrages->contains($ouvrage)) {
            $this->ouvrages->removeElement($ouvrage);
            // set the owning side to null (unless already changed)
            if ($ouvrage->getTechnologie() === $this) {
                $ouvrage->setTechnologie(null);
            }
        }

        return $this;
    }

}
