<?php

namespace App\Controller;

// use PDO;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
// use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    /**
     * This function display all ingredients
     *
     * @param IngredientRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

     //GET DATA OF DB
    #[Route('/ingredient', name: 'ingredient.index', methods:['GET'])]
    //PaginatorInterface $paginator concernant le système de pagination
    //Le repository concerne tout ce qui y'a avoir avec la réccupération des données
    public function index(IngredientRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
            //Debut système de pagination
            $ingredients = $paginator->paginate(
            //Avec le repository, on a appélé la méthode findAll et on la passé dans $paginator->paginate pour avoir une pagination correcte donnée par le bundle knp paginator (use Knp\Component\Pager\PaginatorInterface;)
            $ingredients = $repository->findAll(), /* query not result */
            $request->query->getInt('page', 1), /* page number */
            10 /* Limit pages */
        );
            //Fin système de pagination
        
        // $ingredients = $repository->findAll();
        // dd($ingredients);
        return $this->render('pages/ingredient/index.html.twig', [
           'ingredients' => $ingredients
        ]);
    }

    //POST DATA IN DB
    //Après avoir crée ingredientType avec la cde php bin/console make:form,
    //on crée notre formulaire
    #[Route('/ingredient/nouveau', name: 'ingredient.new', methods:['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
        ) : Response {
        //On crée un nouveau ingrédient
        $ingredients = new Ingredient();
        //On crée le formulaire d'ajout
        $form = $this->createForm(IngredientType::class, $ingredients);

        $form->handleRequest($request);
            // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
            $ingredient = $form->getData();
            // dd($ingredient);
            //On prépare pour l'envoit dans la bd comme un commit
            $manager->persist($ingredient);
             //On envoit dans la bd comme un push
            $manager->flush();

            //Message flash (de confirmation) sur symfony
            $this->addFlash(
                'success',
                'Votre ingrédient a été ajouté avec succes !'
            );
            //Rédirigeons l'utilisateur vers la page de tous les ingrédients
            // $this->redirectToRoute('ingredient.index');
        }else {
            # code...
        }
        return $this->render('pages/ingredient/new.html.twig', [
            'form' => $form->createView()
         ]);
    }
}
