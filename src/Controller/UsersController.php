<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    /**
     * @Route("/users/add", name="users/add")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function add(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
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

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $user = new User();
            $user->setUsername($data['username']);
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $data['password'])
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('app_login'));

        }

        return $this->render('users/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
