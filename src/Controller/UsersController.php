<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    public function add($value='')
    {
      // code...
    }
    /**
     * @Route("users/login", name="users/login")
     */
    public function login($value='')
    {
      // code...
    }
    /**
    * @Route("users/profile", name="users/profile")
    */
    public function profile($value='')
    {
      // code...
    }
}
