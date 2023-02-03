<?php

namespace App\Entity;

class SearchBar
{
    public ?string $type = null;
    public ?string $valley = null;
    public ?string $season = null;

    public function getType(): ?string
    {
        return $this->type;
    }
    public function setType(?string $type): SearchBar
    {
        $this->type = $type;

        return $this;
    }
    public function getValley(): ?string
    {
        return $this->valley;
    }
    public function setValley(?string $valley): ?SearchBar
    {
        $this->valley = $valley;

        return $this;
    }
    public function getSeason(): string
    {
        return $this->season;
    }
    public function setSeason(?string $season): ?SearchBar
    {
        $this->season = $season;

        return $this;
    }
}
