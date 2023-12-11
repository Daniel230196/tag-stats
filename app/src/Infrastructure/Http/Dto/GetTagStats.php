<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Dto;

use App\Domain\Entity\ValueObject\TagType;
use Symfony\Component\Validator\Constraints as Assert;

class GetTagStats
{
    public function __construct(
        #[Assert\NotBlank]
        private readonly \DateTime $startDate,
        #[Assert\NotBlank]
        private readonly \DateTime $endDate,
        #[Assert\NotBlank]
        #[Assert\Choice(TagType::AVAILABLE_TYPES)]
        private readonly string $type
    ) {
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    public function getType(): string
    {
        return $this->type;
    }
}