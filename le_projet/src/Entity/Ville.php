<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 */
class Ville
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pop;

    /**
     * @ORM\Column(type="integer")
     */
    private $dept;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPop(): ?int
    {
        return $this->pop;
    }

    public function setPop(?int $pop): self
    {
        $this->pop = $pop;

        return $this;
    }

    public function getDept(): ?int
    {
        return $this->dept;
    }

    public function setDept(int $dept): self
    {
        $this->dept = $dept;

        return $this;
    }
}
