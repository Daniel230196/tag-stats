<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\ValueObject\TagType;
use App\Infrastructure\Repository\TagRepository;
use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Uid\Uuid;

#[ORM\Table(name: 'tags')]
#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\UniqueConstraint('tags', ['uuid'])]
#[ORM\UniqueConstraint('tags', ['name'])]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private string $uuid;
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING)]
    private string $color;

    #[ORM\Column(type: Types::INTEGER)]
    private int $score;

    #[ORM\Embedded(class: TagType::class, columnPrefix: false)]
    private TagType $type;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    private CarbonImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Gedmo\Timestampable(on: 'update')]
    private CarbonImmutable $updatedAt;

    public function __construct(string $name, string $color, TagType $type, int $score)
    {
        $this->uuid = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->color = $color;
        $this->type = $type;
        $this->score = $score;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getCreatedAt(): ?CarbonImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?CarbonImmutable
    {
        return $this->updatedAt;
    }

    public function getType(): string
    {
        return $this->type->type();
    }

    public function getScore(): int
    {
        return $this->score;
    }

}
