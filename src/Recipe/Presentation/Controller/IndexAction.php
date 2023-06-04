<?php

namespace App\Recipe\Presentation\Controller;

use App\Recipe\Domain\Port\Gateway\RecipeGateway;
use App\Recipe\RecipeDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recipes', name: 'recipe.index', methods: ['GET'])]
final class IndexAction extends AbstractController
{
    public function __construct(private readonly RecipeGateway $recipeGateway)
    {
    }

    public function __invoke(): Response
    {
        $test = RecipeDto::create([
            'title' => 'title',
            'name' => 'name',
        ]);
        dd($test);
        $recipes = $this->recipeGateway->all();


        return $this->render('recipes/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }
}