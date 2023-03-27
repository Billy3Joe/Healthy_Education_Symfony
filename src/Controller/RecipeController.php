<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
// use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Repository\RecipeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
     /**
     * This controller display all recipes
     *
     * @param RecipesRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    //GET DATA OF DB
    #[Route('/recette', name: 'recipe.index', methods:['GET'])]
    public function index(
        RecipeRepository $repository, 
        PaginatorInterface $paginator, 
        Request $request
    ): Response{
          //Debut système de pagination
          $recipes = $paginator->paginate(
            //Avec le repository, on a appélé la méthode findAll et on la passé dans $paginator->paginate pour avoir une pagination correcte donnée par le bundle knp paginator (use Knp\Component\Pager\PaginatorInterface;)
            $repository->findAll(), /* query not result */
            $request->query->getInt('page', 1), /* page number */
            10 /* Limit pages */
        );
            //Fin système de pagination
        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

     //POST DATA IN DB
     #[Route('/recette/creation', name: 'recipe.new', methods:['GET', 'POST'])]
     public function new(
         Request $request,
        //  EntityManagerInterface $manager 
     ) : Response 
     {
         //On crée un nouveau ingrédient
         $recipe = new Recipe();
         //On crée le formulaire d'ajout
         $form = $this->createForm(RecipeType::class, $recipe);
 
         
         return $this->render('pages/recipe/new.html.twig', [
             'form' => $form->createView()
          ]);
     }
 
}
