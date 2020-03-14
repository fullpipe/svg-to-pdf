<?php

namespace App;

class ToPdf
{
    /**
     * @var string
     */
    private $svg;

    /**
     * @var float
     */
    private $width;

    /**
     * @var float
     */
    private $height;

    public function getSvg(): ?string
    {
        return $this->svg;
    }

    public function setSvg(string $svg = null): self
    {
        $this->svg = $svg;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(float $width = null): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height = null): self
    {
        $this->height = $height;

        return $this;
    }
}
