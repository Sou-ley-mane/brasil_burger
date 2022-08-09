<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonneRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"role",type:"string")]
#[ORM\DiscriminatorMap(["user"=>"User"])]

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
// #[ApiResource]
 class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['burger:read:simple','burger:write:simple', 
    'personne:client:read',
    'personne:client:lecture'])]
    private $id;

    #[Groups([
        'personne:gestionnaire:write',
        "personne:gestionnaire:read",
        'personne:client:write',
        'personne:client:read',
        'personne:client:lecture',
        'personne:livreur:write',
        'personne:livreur:read',
        'commande:read'
        ])]
    // #[Groups(['personne:read:client','personne:livreur:read'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;
    
    // #[Groups(['personne:read:client','personne:livreur:read'])]
    #[Groups([
        'personne:gestionnaire:write',
        "personne:gestionnaire:read",
        'personne:client:write',
        'personne:client:read',
    'personne:client:lecture',
        'personne:livreur:write',
        'personne:livreur:read',
        'commande:read'
    
    ])]
    #[ORM\Column(type: 'string', length: 200)]
    private $nom;

    // #[Groups([
    //     "personne:gestionnaire:read"
    // ])]
    #[ORM\Column(type: 'string',nullable:true, length: 200)]
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
