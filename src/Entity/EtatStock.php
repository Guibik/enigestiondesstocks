<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtatStockRepository")
 */
class EtatStock
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateEtatStock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stockTotal;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiteEntree;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantiteSortie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detailOperation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ouvrage", inversedBy="etatStocks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ouvrage;

//    public function __construct()
//    {
//        $this->quantiteEntree = $this->getStockTotal()+$this->getQuantiteEntree();
//        $this->stockTotal = $this->stockTotal-$this->quantiteSortie;
//    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEtatStock(): ?\DateTimeInterface
    {
        return $this->dateEtatStock;
    }

    public function setDateEtatStock(?\DateTimeInterface $dateEtatStock): self
    {
        $this->dateEtatStock = $dateEtatStock;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStockTotal()
    {
        return $this->stockTotal;
    }

    /**
     * @param mixed $stockTotal
     * @return EtatStock
     */
    public function setStockTotal($stockTotal)
    {
        $this->stockTotal = $stockTotal;
        return $this;
    }

    public function getQuantiteEntree(): ?int
    {
        return $this->quantiteEntree;
    }

    public function setQuantiteEntree(?int $quantiteEntree): self
    {
        $this->quantiteEntree = $quantiteEntree;

        return $this;
    }

    public function getQuantiteSortie(): ?int
    {
        return $this->quantiteSortie;
    }

    public function setQuantiteSortie(?int $quantiteSortie): self
    {
        $this->quantiteSortie = $quantiteSortie;

        return $this;
    }

    public function getDetailOperation(): ?string
    {
        return $this->detailOperation;
    }

    public function setDetailOperation(?string $detailOperation): self
    {
        $this->detailOperation = $detailOperation;

        return $this;
    }

    public function getOuvrage(): ?Ouvrage
    {
        return $this->ouvrage;
    }

    public function setOuvrage(?Ouvrage $ouvrage): self
    {
        $this->ouvrage = $ouvrage;

        return $this;
    }

}
