<?php

declare(strict_types=1);

namespace App\Recipe\Domain\Model;

use App\Recipe\Domain\ValueObject\RecipeId;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class Recipe
{
    #[Embedded(columnPrefix: false)]
    private readonly RecipeId $id;

    public function __construct(
        #[Column(length: 60)] public string $name,
        #[Column(type: Types::TEXT)] public string $description,
    ) {
        $this->id = RecipeId::create();
    }

    public function id(): RecipeId
    {
        return $this->id;
    }
}