<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     * @param ProductRepository $productRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ProductRepository $productRepository): Response
    {
        $productRepository = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findProductsJoinedByCategory();
        return $this->render('products/index.html.twig', [
            'products' => $productRepository,
        ]);
    }

    /**
     * @Route("/products/add", name="products/add", methods={"GET","POST"})
     * @param Request $request
     */
    public function add(Request $request, CategoryRepository $categoryRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            //Flash message
            $this->addFlash(
                'product_saved',
                'Product has been saved successfully'
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('products');
        }

        return $this->render('products/add.html.twig',[
            //'categories' => $categoryRepository->findAll(),
            'product' => $product,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/products/edit/{id}", name="products/edit", methods={"GET","POST"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            //Flash message
            $this->addFlash(
                'product_updated',
                'Product has been updated successfully !'
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('products');
        }

        return $this->render('products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/products/delete/{id}", name="products/delete", methods={"DELETE"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token')))
        {
            //Flash message
            $this->addFlash(
                'product_removed',
                'Product has been removed successfully !'
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('products');
    }
}
