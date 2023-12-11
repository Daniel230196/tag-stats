<?php

declare(strict_types=1);

namespace App\Domain\Entity\ValueObject;

use App\Domain\Exception\InvalidTagTypeException;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class TagType
{
    public const TYPE_FIRST = 'FIRST';
    public const TYPE_SECOND = 'SECOND';

    public const AVAILABLE_TYPES = [
        self::TYPE_FIRST,
        self::TYPE_SECOND,
    ];

    #[ORM\Column(type: Types::STRING)]
    private string $type;

    public function __construct(string $type)
    {
        if (!in_array($type, self::AVAILABLE_TYPES)) {
            throw new InvalidTagTypeException();
        }

        $this->type = $type;
    }

    public function type(): string
    {
        return $this->type;
    }
}