<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/', name: 'app_hello')]
    public function hello(): Response
    {
        return new Response ('Hello world');
    }

    #[Route('/blog', name: 'app_blog')]
    public function allArticles(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_blog' => 'BlogController',
        ]);
    }

    #[Route('/blog/{id}/{name}', name: 'app_blog', requirements:["id" => "[0-9]{2,6}", "name" =>"[a-zA-Z]{3,50}"])]
    public function singleArticle(int $id, string $name): Response
    {
        return $this->render('blog/index.html.twig', [
            'id' => $id,
            'name' => $name,
            'controller_blog' => 'BlogController',
        ]);
    }
}
