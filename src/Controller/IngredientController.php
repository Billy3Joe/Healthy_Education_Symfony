<?php

namespace App\Controller;

// use PDO;
use App\Repository\IngredientRepository;
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
    #[Route('/ingredient', name: 'app_ingredient', methods:['GET'])]
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
}
