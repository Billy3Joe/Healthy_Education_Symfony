<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
// use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * This controller allow us to edit user's profile
     *
     * @param User $choosenUser
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods: ['GET', 'POST'])]
    public function edit(
        User $user, 
        request $request,
        EntityManagerInterface $manager 
        ): Response
    {
        // if (!$this->getUser()) {
        //     return $this->redirectToRoute('security.login');
        // }
        // dd($user, $this->getUser());
        // if ($this->getUser() !== $user) {
        //     return $this->redirectToRoute('recipe.index');
        // }

        $form = $this->createForm(UserType::class, $user);
        $form ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
            $user = $form->getData();
            // dd($ingredient);
            //On prépare pour l'envoit dans la bd comme un commit
            $manager->persist($user);
             //On envoit dans la bd comme un push
            $manager->flush();

            //Message flash (de confirmation) sur symfony
            $this->addFlash(
                'success',
                'Les informations de votre utilisateur a été modifié avec succes !'
            );
            //Rédirigeons l'utilisateur vers la page de tous les ingrédients
           return $this->redirectToRoute('recipe.index');
        }
        
        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
