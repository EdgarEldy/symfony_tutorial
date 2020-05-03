<?php

namespace App\Controller;

use App\Entity\Product;
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
    public function add(Request $request): Response
    {


    }

    /**
     * @Route("/products/edit/{id}", name="products/edit", methods={"GET","POST"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function edit(Request $request, Product $product): Response
    {

    }

    /**
     * @Route("/products/delete/{id}", name="products/delete", methods={"DELETE"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function delete(Request $request, Product $product): Response
    {

    }
}
