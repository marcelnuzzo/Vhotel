<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryHotelRepository")
 */
class CategoryHotel
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
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hotel", mappedBy="categoryHotel", orphanRemoval=true)
     */
    private $hotels;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="catHotel", orphanRemoval=true)
     */
    private $catHotel;

    public function __construct()
    {
        $this->hotels = new ArrayCollection();
        $this->catHotel = new ArrayCollection();
        $this->priceRoom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Hotel[]
     */
    public function getHotels(): Collection
    {
        return $this->hotels;
    }

    public function addHotel(Hotel $hotel): self
    {
        if (!$this->hotels->contains($hotel)) {
            $this->hotels[] = $hotel;
            $hotel->setCategoryHotel($this);
        }

        return $this;
    }

    public function removeHotel(Hotel $hotel): self
    {
        if ($this->hotels->contains($hotel)) {
            $this->hotels->removeElement($hotel);
            // set the owning side to null (unless already changed)
            if ($hotel->getCategoryHotel() === $this) {
                $hotel->setCategoryHotel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getCatHotel(): Collection
    {
        return $this->catHotel;
    }

    public function addCatHotel(Room $catHotel): self
    {
        if (!$this->catHotel->contains($catHotel)) {
            $this->catHotel[] = $catHotel;
            $catHotel->setCatHotel($this);
        }

        return $this;
    }

    public function removeCatHotel(Room $catHotel): self
    {
        if ($this->catHotel->contains($catHotel)) {
            $this->catHotel->removeElement($catHotel);
            // set the owning side to null (unless already changed)
            if ($catHotel->getCatHotel() === $this) {
                $catHotel->setCatHotel(null);
            }
        }

        return $this;
    }

}
