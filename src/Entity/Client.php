<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "client_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"client_list"})
 * )
 * @Hateoas\Relation(
 *      "client_list",
 *      href = @Hateoas\Route(
 *          "client_list",
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="client_detail")
 * )
 * @Hateoas\Relation(
 *      "create",
 *      href = @Hateoas\Route(
 *          "client_create",
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"client_list","client_detail"})
 * )
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "client_delete",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"client_list","client_detail"})
 * )
 * @Hateoas\Relation(
 *     "related_user",
 *     href = @Hateoas\Route(
 *         "api_user_show",
 *         parameters = { "id" = "expr(object.getUser().getId())" }
 *     ),
 *     exclusion = @Hateoas\Exclusion("client_detail")
 * )
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Groups({"client_list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Cette valeur ne peut être nulle.")
     * @Assert\Length(
     *     max = 50, 
     *     maxMessage = "Le prénom ne peut dépasser 50 caractères."
     * )
     *
     * @Serializer\Groups({"client_list", "client_detail"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Cette valeur ne peut être nulle.")
     * @Assert\Length(
     *     max = 50, 
     *     maxMessage = "Le nom ne peut dépasser 50 caractères."
     * )
     *
     * @Serializer\Groups({"client_list", "client_detail"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="Cette valeur ne peut être nulle.")
     * @Assert\Length(
     *     max = 100, 
     *     maxMessage = "L'adresse ne peut dépasser 100 caractères."
     * )
     *
     * @Serializer\Groups({"client_detail"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\Regex(
     *     pattern="#[0-9]{5}#",
     *     match=true,
     *     message="Le code postal doit comporter 5 chiffres"
     * )
     *
     * @Serializer\Groups({"client_list", "client_detail"})
     */
    private $postCode;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(
     *     max = 50, 
     *     maxMessage = "Le nom de la ville ne peut dépasser 50 caractères"
     * )
     *
     * @Serializer\Groups({"client_list", "client_detail"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Regex(
     *     pattern="#[0-9]{10}#",
     *     match=true,
     *     message="Le numéro de téléphone doit comporter 10 chiffres"
     * )
     *
     * @Serializer\Groups({"client_detail"})
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Email(message="L'email saisi n'est pas une adresse mail correcte.")
     *
     * @Serializer\Groups({"client_detail"})
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
