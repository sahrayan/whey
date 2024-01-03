<?php

namespace App\Controller;

// Assurez-vous d'inclure le bon namespace pour ProductRepository
use App\Repository\ProductRepository; 

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll(); // Récupère tous les produits

        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
