<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cat_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatName(): ?string
    {
        return $this->cat_name;
    }

    public function setCatName(string $cat_name): self
    {
        $this->cat_name = $cat_name;

        return $this;
    }
}