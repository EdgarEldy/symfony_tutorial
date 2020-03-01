<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomersController extends AbstractController
{
    /**
     * @Route("/customers", name="customers")
     */
    public function index()
    {
        return $this->render('customers/index.html.twig', [
            'controller_name' => 'CustomersController',
        ]);
    }
}
