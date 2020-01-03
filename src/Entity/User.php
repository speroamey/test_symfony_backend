<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Serializer\Annotation\Type("string")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Serializer\Annotation\Type("string")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $created_date;

    /**
     * @ORM\Column(type="date")
     * @JMS\Serializer\Annotation\Type("datetime")
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $updated_date;

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

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updated_date;
    }

    public function setUpdatedDate(\DateTimeInterface $updated_date): self
    {
        $this->updated_date = $updated_date;

        return $this;
    }
}
