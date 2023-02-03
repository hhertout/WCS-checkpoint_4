<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\PointOfInterestRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PointOfInterestRepository::class)]
#[Vich\Uploadable]
class PointOfInterest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Hike::class, mappedBy: 'pointOfInterests')]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $hikes;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $poster = null;

    #[Vich\UploadableField(mapping: 'poster_file', fileNameProperty: 'poster')]
    #[Assert\File(
        maxSize: '100M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $posterFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?Datetime $updatedAt = null;

    public function __construct()
    {
        $this->hikes = new ArrayCollection();
    }

    public function setPoster(string $poster): PointOfInterest
    {
        $this->poster = $poster;

        return $this;
    }
    public function getPoster(): ?string
    {
        return $this->poster;
    }
    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }
    public function setPosterFile(File $posterFile): PointOfInterest
    {
        $this->posterFile = $posterFile;
        if ($posterFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
            $hike->addPointOfInterest($this);
        }

        return $this;
    }

    public function removeHike(Hike $hike): self
    {
        if ($this->hikes->removeElement($hike)) {
            $hike->removePointOfInterest($this);
        }

        return $this;
    }
}
