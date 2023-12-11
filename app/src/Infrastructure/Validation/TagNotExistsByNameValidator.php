<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

use App\Infrastructure\Repository\TagRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TagNotExistsByNameValidator extends ConstraintValidator
{

    public function __construct(private readonly TagRepository $tagRepository)
    {
    }

    /**
     * @param mixed $value
     * @param TagNotExistsByName $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!is_string($value)) {
            throw new \RuntimeException('Only string values is applicable');
        }

        if ($this->tagRepository->findOneBy(['name' => $value]) !== null) {
            $this->context->buildViolation($constraint->message)
                ->atPath('tagName')
                ->addViolation()
            ;
        }

    }
}