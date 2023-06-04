<?php

declare(strict_types=1);

namespace App\Recipe\Domain\ValueObject;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Uid\Uuid;

#[Embeddable]
final class RecipeId implements \Stringable
{
    public static function create(): self
    {
        return new self('re_' . Uuid::v4()->toBase58());
    }

    public function value(): string
    {
        return $this->id;
    }

    private function __construct(
        #[Id] #[Column] private readonly string $id
    ) {
        if (!str_starts_with($id, 're_')) {
            throw new \InvalidArgumentException('Wrong ID value.');
        }
    }

    public function __toString(): string
    {
        return $this->value();
    }
}