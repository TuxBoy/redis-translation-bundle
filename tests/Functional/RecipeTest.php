<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Recipe\Domain\Port\Gateway\RecipeGateway;
use App\Tests\Factory\DummyRecipeFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RecipeTest extends WebTestCase
{
    public function testListing(): void
    {
        $client = static::createClient();

        $recipes = [
            DummyRecipeFactory::createRecipe(),
            DummyRecipeFactory::createRecipe(name: 'Recipe de test', description: 'Super description'),
        ];

        /** @var RecipeGateway $repository */
        $repository = self::getContainer()->get(RecipeGateway::class);
        foreach ($recipes as $recipe) {
            $repository->create($recipe);
        }

        $crawler = $client->request(method: 'GET', uri: '/recipes');

        $this->assertResponseIsSuccessful();

        $this->assertSame('Recipe', $crawler->filter('li')->text());
        $this->assertCount(2, $crawler->filter('li'));
    }
}