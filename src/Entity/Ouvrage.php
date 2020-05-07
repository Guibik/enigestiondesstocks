<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OuvrageRepository")
 */
class Ouvrage
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $isbn;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbreTome;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrePage;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteStock;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Filiere", inversedBy="ouvrages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $filiere;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Technologie", inversedBy="ouvrages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $technologie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SiteEntreposage", inversedBy="ouvrages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EtatStock", mappedBy="ouvrage")
     */
    private $etatStocks;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiteEntree;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiteSortie;

    /**
     * @return mixed
     */
    public function getQuantiteEntree()
    {
        return $this->quantiteEntree;
    }

    /**
     * @param mixed $quantiteEntree
     * @return Ouvrage
     */
    public function setQuantiteEntree($quantiteEntree)
    {
        $this->quantiteEntree = $quantiteEntree;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantiteSortie()
    {
        return $this->quantiteSortie;
    }

    /**
     * @param mixed $quantiteSortie
     * @return Ouvrage
     */
    public function setQuantiteSortie($quantiteSortie)
    {
        $this->quantiteSortie = $quantiteSortie;
        return $this;
    }




    public function __construct()
    {
        $this->etatStocks = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->titre;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsbn(): ?int
    {
        return $this->isbn;
    }

    public function setIsbn(?int $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getNbreTome(): ?int
    {
        return $this->nbreTome;
    }

    public function setNbreTome(int $nbreTome): self
    {
        $this->nbreTome = $nbreTome;

        return $this;
    }

    public function getNbrePage(): ?int
    {
        return $this->nbrePage;
    }

    public function setNbrePage(?int $nbrePage): self
    {
        $this->nbrePage = $nbrePage;

        return $this;
    }

    public function getQuantiteStock(): ?int
    {
        return $this->quantiteStock;
    }

    public function setQuantiteStock(int $quantiteStock): self
    {
        $this->quantiteStock = $quantiteStock;

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getTechnologie(): ?Technologie
    {
        return $this->technologie;
    }

    public function setTechnologie(?Technologie $technologie): self
    {
        $this->technologie = $technologie;

        return $this;
    }

    public function getSite(): ?SiteEntreposage
    {
        return $this->site;
    }

    public function setSite(?SiteEntreposage $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection|EtatStock[]
     */
    public function getEtatStocks(): Collection
    {
        return $this->etatStocks;
    }

    public function addEtatStock(EtatStock $etatStock): self
    {
        if (!$this->etatStocks->contains($etatStock)) {
            $this->etatStocks[] = $etatStock;
            $etatStock->setOuvrage($this);
        }

        return $this;
    }

    public function removeEtatStock(EtatStock $etatStock): self
    {
        if ($this->etatStocks->contains($etatStock)) {
            $this->etatStocks->removeElement($etatStock);
            // set the owning side to null (unless already changed)
            if ($etatStock->getOuvrage() === $this) {
                $etatStock->setOuvrage(null);
            }
        }

        return $this;
    }

}
