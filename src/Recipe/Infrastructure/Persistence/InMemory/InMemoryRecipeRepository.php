<?php

declare(strict_types=1);

namespace App\Recipe\Infrastructure\Persistence\InMemory;

use App\Recipe\Domain\Model\Recipe;
use App\Recipe\Domain\Port\Gateway\RecipeGateway;

final class InMemoryRecipeRepository implements RecipeGateway
{
    /**
     * @var array<Recipe>
     */
    private array $collection = [];

    public function create(Recipe $recipe): void
    {
        $this->collection[] = $recipe;
    }

    public function all(): iterable
    {
        return $this->collection;
    }
}