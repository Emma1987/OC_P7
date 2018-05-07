<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Groups({"list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @Serializer\Groups({"list", "detail"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Serializer\Groups({"list", "detail"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Serializer\Groups({"detail"})
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Groups({"list", "detail"})
     */
    private $postCode;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @Serializer\Groups({"list", "detail"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=13, nullable=true)
     *
     * @Serializer\Groups({"detail"})
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Serializer\Groups({"detail"})
     */
    private $email;

    public function getId()
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostCode(): ?int
    {
        return $this->postCode;
    }

    public function setPostCode(int $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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
}
