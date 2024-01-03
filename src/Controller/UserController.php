<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{


    #[Route('/user', name: 'user_profile')]
    public function index(): Response
    {
        // Get user information and pass    it to the template, if necessary

        return $this->render('user/profile.html.twig', [
            // Pass any necessary data to the template
        ]);
    }

    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(): Response
    {
        // Ensure that this route is only accessible by admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Get data necessary for the dashboard and pass it to the template

        return $this->render('admin/dashboard.html.twig', [
            // Pass any necessary data to the template
        ]);
    }
}
