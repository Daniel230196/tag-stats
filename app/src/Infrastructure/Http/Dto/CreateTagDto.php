<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Dto;

use App\Infrastructure\Validation\TagNotExistsByName;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTagDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 255)]
        #[TagNotExistsByName]
        private readonly string $name,
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 255)]
        private readonly string $color,
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 255)]
        private readonly string $type,
        #[Assert\NotBlank]
        #[Assert\PositiveOrZero]
        private readonly int $score
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}