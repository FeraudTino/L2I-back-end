<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\ManyToMany(targetEntity: Article::class)]
    private Collection $articlesCommande;

    #[ORM\ManyToOne(inversedBy: 'prixTotalHT')]
    private ?Client $client = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixTotalHT = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixTotalTTC = null;

    #[ORM\OneToOne(mappedBy: 'commande', cascade: ['persist', 'remove'])]
    private ?Facture $facture = null;

    public function __construct()
    {
        $this->articlesCommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(?\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticlesCommande(): Collection
    {
        return $this->articlesCommande;
    }

    public function addArticlesCommande(Article $articlesCommande): self
    {
        if (!$this->articlesCommande->contains($articlesCommande)) {
            $this->articlesCommande->add($articlesCommande);
        }

        return $this;
    }

    public function removeArticlesCommande(Article $articlesCommande): self
    {
        $this->articlesCommande->removeElement($articlesCommande);

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPrixTotalHT(): ?float
    {
        return $this->prixTotalHT;
    }

    public function setPrixTotalHT(?float $prixTotalHT): self
    {
        $this->prixTotalHT = $prixTotalHT;

        return $this;
    }

    public function getPrixTotalTTC(): ?float
    {
        return $this->prixTotalTTC;
    }

    public function setPrixTotalTTC(?float $prixTotalTTC): self
    {
        $this->prixTotalTTC = $prixTotalTTC;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        // unset the owning side of the relation if necessary
        if ($facture === null && $this->facture !== null) {
            $this->facture->setCommande(null);
        }

        // set the owning side of the relation if necessary
        if ($facture !== null && $facture->getCommande() !== $this) {
            $facture->setCommande($this);
        }

        $this->facture = $facture;

        return $this;
    }
}
