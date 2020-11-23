<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 * @ORM\Table(name="`players`")
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 3,
     *     max = 16
     *     )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 3,
     *     max = 16
     *     )
     */
    private $lastname;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $mirian;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\Length(
     *     min = 40,
     *     max = 40
     *     )
     */
    private $identifier;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modification;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMirian(): ?int
    {
        return $this->mirian;
    }

    public function setMirian(int $mirian): self
    {
        $this->mirian = $mirian;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(\DateTimeInterface $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getModification(): ?\DateTimeInterface
    {
        return $this->modification;
    }

    public function setModification(\DateTimeInterface $modification): self
    {
        $this->modification = $modification;

        return $this;
    }
}
