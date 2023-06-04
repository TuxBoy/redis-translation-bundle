<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Recipe\Domain\Model\Recipe;

final class DummyRecipeFactory
{
    public static function createRecipe(string $name = 'Recipe', string $description = 'description'): Recipe
    {
        return new Recipe(name: $name, description: $description);
    }
}