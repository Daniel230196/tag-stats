<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateTagDto
{
    public function __construct(
        #[Assert\NotBlank()]
        #[Assert\Uuid]
        private readonly string $uuid,
        #[Assert\NotBlank]
        #[Assert\Length(min:3 , max: 255)]
        private readonly string $color,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getColor(): string
    {
        return $this->color;
    }
}