<?php

declare(strict_types=1);

namespace App\Recipe\Infrastructure\Persistence\Doctrine;

use App\Recipe\Domain\Model\Recipe;
use App\Recipe\Domain\Port\Gateway\RecipeGateway;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineRecipeRepository implements RecipeGateway
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function create(Recipe $recipe): void
    {
        $this->entityManager->persist($recipe);
    }

    public function all(): iterable
    {
        return $this->entityManager->getRepository(Recipe::class)->findAll();
    }
}