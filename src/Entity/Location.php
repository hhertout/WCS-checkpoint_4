<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $valley = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Hike::class, cascade:["persist", "remove"])]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $hikes;

    public function __construct()
    {
        $this->hikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValley(): ?string
    {
        return $this->valley;
    }

    public function setValley(string $valley): self
    {
        $this->valley = $valley;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection<int, Hike>
     */
    public function getHikes(): Collection
    {
        return $this->hikes;
    }

    public function addHike(Hike $hike): self
    {
        if (!$this->hikes->contains($hike)) {
            $this->hikes->add($hike);
            $hike->setLocation($this);
        }

        return $this;
    }

    public function removeHike(Hike $hike): self
    {
        if ($this->hikes->removeElement($hike)) {
            // set the owning side to null (unless already changed)
            if ($hike->getLocation() === $this) {
                $hike->setLocation(null);
            }
        }

        return $this;
    }
}
