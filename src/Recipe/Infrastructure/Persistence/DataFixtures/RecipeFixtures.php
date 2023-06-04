<?php

namespace App\Recipe\Infrastructure\Persistence\DataFixtures;

use App\Recipe\Domain\Model\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $manager->persist(
                new Recipe(
                    name: sprintf('Recipe+%d', $i),
                    description:  sprintf('Description od recipe %d', $i)
                )
            );
        }

        $manager->flush();
    }
}
