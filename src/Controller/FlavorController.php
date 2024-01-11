<?php

// src/Controller/FlavorController.php

namespace App\Controller;

use App\Entity\Flavor;
use App\Form\FlavorType;
use App\Repository\FlavorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/flavor')]
class FlavorController extends AbstractController
{
    #[Route('/', name: 'flavor_index', methods: ['GET'])]
    public function index(FlavorRepository $repository, Request $request): Response
    {
        $flavors = $repository->findAll();
    
        // Création du formulaire
        $form = $this->createForm(FlavorType::class);
        $form->handleRequest($request);
    
        return $this->render('flavor/index.html.twig', [
            'flavors' => $flavors,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/new', name: 'flavor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $flavor = new Flavor();
        $form = $this->createForm(FlavorType::class, $flavor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($flavor);
            $entityManager->flush();

            return $this->redirectToRoute('flavor_index');
        }

        return $this->render('flavor/new.html.twig', [
            'flavor' => $flavor,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'flavor_show', methods: ['GET'])]
    public function show(Flavor $flavor): Response
    {
        // Création du formulaire (si nécessaire)
        $form = $this->createForm(FlavorType::class, $flavor);
    
        return $this->render('flavor/show.html.twig', [
            'flavor' => $flavor,
            'form' => $form->createView(), // Assurez-vous de passer le formulaire
        ]);
    }
    

    #[Route('/{id}/edit', name: 'flavor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Flavor $flavor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FlavorType::class, $flavor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('flavor_index');
        }

        return $this->render('flavor/edit.html.twig', [
            'flavor' => $flavor,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'flavor_delete', methods: ['POST'])]
    public function delete(Request $request, Flavor $flavor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flavor->getId(), $request->request->get('_token'))) {
            $entityManager->remove($flavor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('flavor_index');
    }
}
    