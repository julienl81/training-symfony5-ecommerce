<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/nos-produits", name="app_products")
     */
    public function index(ProductRepository $productRepository, Search $search, Request $request): Response
    {
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $products = $productRepository->findWithSearch($search);
            //dd($search);
        } else {
            $products = $productRepository->findAll();
        }

        return $this->renderForm('product/index.html.twig', [
            'products' => $products,
            'form' => $form
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="app_product")
     */
    public function show($slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBySlug($slug);

        if (!$product) {
            return $this->redirectToRoute('app_products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
