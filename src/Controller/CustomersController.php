<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomersController extends AbstractController
{
    /**
     * @Route("/customers", name="customers", methods={"GET"})
     */
    public function index(CustomerRepository $customerRepository): Response
    {
        return $this->render('customers/index.html.twig', [
            'customers' => $customerRepository->findAll()
        ]);
    }

    /**
     * @Route("/customers/add", name="customers/add", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            //Flash message
            $this->addFlash(
                'customer_saved',
                'Customer has been saved successfully !'
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('customers');
        }
        return $this->render('customers/add.html.twig',[
            'customer' => $customer,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/customers/edit/{id}", name="customers/edit", methods={"GET","POST"})
     * @param Request $request
     * @param Customer $customer
     * @return Response
     */
    public function edit(Request $request, Customer $customer): Response
    {
        //Flash message
        $this->addFlash(
            'customer_updated',
            'Customer has been updated successfully !'
        );
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('customers');
        }

        return $this->render('customers/edit.html.twig',[
           'customer' => $customer,
           'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/customers/delete/{id}", name="customers/delete", methods={"DELETE"})
     * @param Request $request
     * @param Customer $customer
     * @return Response
     */
    public function delete(Request $request, Customer $customer): Response
    {
    if ($this->isCsrfTokenValid('delete'.$customer->getId(),$request->request->get('_token')))
    {
        //Flash message
        $this->addFlash(
            'customer_deleted',
            'Customer has been removed successfully !'
        );
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($customer);
        $entityManager->flush();
    }

    return $this->redirectToRoute('customers');
    }


}
