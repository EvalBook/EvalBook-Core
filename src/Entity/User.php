<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
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
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;


    /**
     * Return the User ID.
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Return the User email.
     * @return string|null
     */
    public function getEmail(): ?string {
        return $this->email;
    }


    /**
     * Set the User email.
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     * @see UserInterface
     */
    public function getUsername(): string {
        return (string) $this->email;
    }

    /**
     * Return the User Roles list.
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Set the User roles list.
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Return the User password.
     * @see UserInterface
     */
    public function getPassword(): string {
        return (string) $this->password;
    }

    /**
     * Set the Use rpassword.
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt() {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Return the User first name.
     * @return string|null
     */
    public function getFirstname(): ?string {
        return $this->firstname;
    }

    /**
     * Set the User first name.
     * @param string $firstname
     * @return $this
     */
    public function setFirstname(string $firstname): self {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Return the User last name.
     * @return string|null
     */
    public function getLastname(): ?string {
        return $this->lastname;
    }

    /**
     * Set the User last name.
     * @param string $lastname
     * @return $this
     */
    public function setLastname(string $lastname): self {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Return the User string representation.
     * @return string
     */
    public function __toString(): string {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }
}
