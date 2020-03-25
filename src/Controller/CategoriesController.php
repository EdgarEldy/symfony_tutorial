<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('categories/index.html.twig', [
            'categories' => $categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/categories/add", name="categories/add", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('categories');
        }
    return $this->render('categories/add.html.twig',[
        'category' => $category,
        'form' => $form->createView(),
    ]);
    }

    /**
     * @Route("/categories/show/{id}", name="categories/show", methods={"GET"})
     * @param Category $category
     * @return Response
     */
    public function show(Category $category): Response
    {
        return $this->render('categories/show.html.twig',[
            'category' => $category,
        ]);
    }

    /**
     * @Route("/categories/edit/{id}", name="categories/edit", methods={"GET","POST"})
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function edit(Request $request, Category $category): Response
    {
    $form = $this->createForm(CategoryType::class,$category);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid())
    {
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('categories');
    }

    return $this->render('categories/edit.html.twig',[
        'category' => $category,
        'form' => $form->createView()
    ]);
    }

    /**
     * @Route("/categories/delete/{id}", name="categories/delete", methods={"DELETE"})
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(),$request->request->get('_token'))){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categories');
    }


}
