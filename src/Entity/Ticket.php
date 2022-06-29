<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numFacture;

    #[ORM\OneToMany(mappedBy: 'ticket', targetEntity: LigneCommande::class)]
    private $ligneDeCmds;

    public function __construct()
    {
        $this->ligneDeCmds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFacture(): ?string
    {
        return $this->numFacture;
    }

    public function setNumFacture(?string $numFacture): self
    {
        $this->numFacture = $numFacture;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneDeCmds(): Collection
    {
        return $this->ligneDeCmds;
    }

    public function addLigneDeCmd(LigneCommande $ligneDeCmd): self
    {
        if (!$this->ligneDeCmds->contains($ligneDeCmd)) {
            $this->ligneDeCmds[] = $ligneDeCmd;
            $ligneDeCmd->setTicket($this);
        }

        return $this;
    }

    public function removeLigneDeCmd(LigneCommande $ligneDeCmd): self
    {
        if ($this->ligneDeCmds->removeElement($ligneDeCmd)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCmd->getTicket() === $this) {
                $ligneDeCmd->setTicket(null);
            }
        }

        return $this;
    }
}
