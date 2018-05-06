<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MobileRepository")
 */
class Mobile
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
    private $brand;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @Serializer\Groups({"list", "detail"})
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @Serializer\Groups({"list", "detail"})
     */
    private $memory;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Groups({"detail"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     *
     * @Serializer\Groups({"detail"})
     */
    private $price;

    public function getId()
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getMemory(): ?string
    {
        return $this->memory;
    }

    public function setMemory(string $memory): self
    {
        $this->memory = $memory;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
