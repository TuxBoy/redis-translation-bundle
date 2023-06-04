<?php

declare(strict_types=1);

namespace App\Recipe\Domain\Port\Gateway;

use App\Recipe\Domain\Model\Recipe;

interface RecipeGateway
{
    public function create(Recipe $recipe): void;

    public function all(): iterable;
}