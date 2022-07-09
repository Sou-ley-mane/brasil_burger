<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

//  #[ApiResource]
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @ApiResource( 
 * 
 * normalizationContext={"groups"={"user:read"}},
 * denormalizationContext={"groups"={"user:write"}}
 * )
 */
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"role",type:"string")]
#[ORM\DiscriminatorMap(["GESTIONNAIRE"=>"Gestionnaire", "CLIENT"=>"Client","LIVREUR"=>"Livreur"])]

#[ORM\Entity(repositoryClass: UserRepository::class)]
//les operations
#[ApiResource(
    collectionOperations:[
        "post",
        "get",
        "post_register" => [
        "method"=>"post",
        'path'=>'/register',
        // 'denormalization_context' => ['groups' => ['user:write']],
        // 'normalization_context' => ['groups' => ['user:read:simple']]
        ],
        ],
    itemOperations:["put","get"]
 )]
class User extends Personne implements UserInterface, PasswordAuthenticatedUserInterface
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    // private $id;
    // #[Groups(['personne:read:client','personne:livreur:read'])]
    #[Groups([
        'personne:gestionnaire:write',
        "personne:gestionnaire:read",
        'personne:client:write',
        'personne:client:read',
        'personne:livreur:write',
        'personne:livreur:read'
        ])]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\Email(message:"Votre Email '{{ value }}' est non valide.")]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];
    // #[Groups(['user:read:simple'])]
    #[ORM\Column(type: 'string')]
    private $password;

   

 

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

  

 

  

   
}
