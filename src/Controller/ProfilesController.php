<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilesController extends AbstractController
{
    /**
     * @Route("/profiles", name="profiles")
     */
    public function index()
    {
        return $this->render('profiles/index.html.twig', [
            'controller_name' => 'ProfilesController',
        ]);
    }
}
