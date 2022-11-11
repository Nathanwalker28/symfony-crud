<?php

namespace App\Entity;

use Assert\Length;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Ce compte existe déja")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez remplir votre nom de famille !")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string" , length=100)
     * @Assert\Length(
     *          min = 10, 
     *          max = 20,
     *          minMessage = "Le numéro de téléphone ne doit pas être vide",
     *          maxMessage = "Le numéro de téléphone ne doit pas dépasser 20 caractère")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string" , length=255)
     * @Assert\Length(min = 10, minMessage = "Veuillez renseigner votre adresse")
     */
    private $adress;

    /**
     * @ORM\Column(type="string" , length=255)
     * @Assert\Email(message = "Veuillez renseigner un email valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string" , length=100)
     * @Assert\NotBlank(message = "Le mot de passe ne doit pas être vide")
     */
    private $password;

        
    /**
     * passwordConfirm
     *
     * @Assert\EqualTo(propertyPath="password", message="Veuillez confimer votre mot de passe !")
     */
    public $passwordConfirm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url_picture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    {   
        return ['ROLE_USER'];   
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }



    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }



    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string
     *
     */
    public function getUsername()
    {
        return $this->email;
    }

    public function getUrlPicture(): ?string
    {
        return $this->url_picture;
    }

    public function setUrlPicture(?string $url_picture): self
    {
        $this->url_picture = $url_picture;

        return $this;
    }

    
}

