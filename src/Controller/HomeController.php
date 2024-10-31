<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods:['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        $homeProducts = $productRepository->findBy([],['id'=>'DESC'], limit: 3);

        return $this->render('home/index.html.twig', [
            'products' => $homeProducts,
        ]);
    }

    #[Route('/shop', name: 'app_shop', methods:['GET'])]
    public function shop(ProductRepository $productRepository): Response
    {

        return $this->render('shop/index.html.twig', [
            'products' => $productRepository->findBy([],['price'=>'DESC']),
        ]);
    }
    #[Route('/shop/1', name: 'app_shop_1', methods:['GET'])]
    public function shop1(ProductRepository $productRepository): Response
    {

        return $this->render('shop/small.html.twig', [
            'products' => $productRepository->findBy([],['price'=>'DESC']),
        ]);
    }
    #[Route('/shop/2', name: 'app_shop_2', methods:['GET'])]
    public function shop2(ProductRepository $productRepository): Response
    {

        return $this->render('shop/medium.html.twig', [
            'products' => $productRepository->findBy([],['price'=>'DESC']),
        ]);
    }
    #[Route('/shop/3', name: 'app_shop_3', methods:['GET'])]
    public function shop3(ProductRepository $productRepository): Response
    {

        return $this->render('shop/large.html.twig', [
            'products' => $productRepository->findBy([],['price'=>'DESC']),
        ]);
    }

    #[Route('/product/{id}', name: 'app_show_product', methods:['GET'])]
    public function show(Product $product, ProductRepository $productRepository): Response
    {
        $lastProducts = $productRepository->findBy([],['id'=>'DESC'], limit: 5);



        return $this->render('home/show.html.twig', [
            'product' => $product,
            'products'=> $lastProducts
        ]);
    }
}
