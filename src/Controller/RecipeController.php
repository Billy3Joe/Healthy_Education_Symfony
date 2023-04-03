<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
// use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * This controller allow us to create a new recipe
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

     //POST DATA IN DB
     #[Route('/recette/creation', name: 'recipe.new', methods:['GET', 'POST'])]
     public function new(
         Request $request,
         EntityManagerInterface $manager 
     ) : Response 
     {
         //On crée un nouveau ingrédient
         $recipe = new Recipe();
         //On crée le formulaire d'ajout
         $form = $this->createForm(RecipeType::class, $recipe);
         
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
             // dd($form->getData());
             $recipe = $form->getData();
             // dd($ingredient);
             //On prépare pour l'envoit dans la bd comme un commit
             $manager->persist($recipe);
              //On envoit dans la bd comme un push
             $manager->flush();
 
             //Message flash (de confirmation) sur symfony
             $this->addFlash(
                 'success',
                 'Votre recette a été ajouté avec succes !'
             );
             //Rédirigeons l'utilisateur vers la page de tous les ingrédients
            return $this->redirectToRoute('recipe.index');
         }
         
         return $this->render('pages/recipe/new.html.twig', [
             'form' => $form->createView()
          ]);
     }

     //UPDATE DATA IN DB
    //NB: symfony ira seul réccupérer l'id de la recette dans la table Recipe
    /**
     * This controller allow us to update a recipe
     *
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/recette/edition/{id}', name: 'recipe.edit', methods:['GET', 'POST'])]
    public function edit(
        Recipe $recipe, 
        Request $request,
        EntityManagerInterface $manager 
    ) : Response 
    {
        //On crée le formulaire
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        // dd($form);
    if ($form->isSubmitted() && $form->isValid()) {
        // dd($form->getData());
        $recipe = $form->getData();
        // dd($ingredient);
        //On prépare pour l'envoit dans la bd comme un commit
        $manager->persist($recipe);
         //On envoit dans la bd comme un push
        $manager->flush();

        //Message flash (de confirmation) sur symfony
        $this->addFlash(
            'success',
            'Votre recette a été modifié avec succes !'
        );
        //Rédirigeons l'utilisateur vers la page de tous les ingrédients
       return $this->redirectToRoute('recipe.index');
    }else {
        # code...
    }
        return $this->render('pages/recipe/edit.html.twig', [
            'form' => $form->createView()
         ]);
    }

    //DELETE DATA IN DB
    /**
     *  This controller allow us to delete a recipe
     *
     * @param Recipe $recipe
     * @param EntityManagerInterface $manager
     * @return Response
     */

    //NB: symfony ira seul réccupérer l'id de la recette dans la table IRecipe
    #[Route('/recette/suppression/{id}', name: 'recipe.delete', methods:['GET'])]
    public function delete(
        Recipe $recipe, 
        EntityManagerInterface $manager 
    ) : Response 
    {

       $manager->remove($recipe);
       $manager->flush();

       //Message flash (de confirmation) sur symfony
       $this->addFlash(
           'success',
           'Votre recette a été supprimé avec succes !'
       );
       //Rédirigeons l'utilisateur vers la page de tous les ingrédients
       return $this->redirectToRoute('recipe.index');

    }
 
}
