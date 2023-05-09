<?php

namespace App\Controller;

use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post/crear', name: 'post_create')]
    public function create(Request $request, EntityManagerInterface $entityManger ): Response
    {
        $form = $this->createForm(PostType::class);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $entityManger->persist($form->getData());
            $entityManger->flush();

            $this->addFlash('success', 'Publicación guardada con éxito');
            return $this->redirectToRoute('post_create');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
