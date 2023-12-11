<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class TagNotExistsByName extends Constraint
{
    public string $message = 'Тег с таким именем уже существует';
}