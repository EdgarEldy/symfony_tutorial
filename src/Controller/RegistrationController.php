<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/users/register", name="register", methods={"GET","POST"})
     */
    public function register(): Response
    {
        $form = $this->createFormBuilder()
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => TRUE,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm password']
                ])
            ->getForm();

        return $this->render('users/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
