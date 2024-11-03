<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    public function __construct(private readonly ProductRepository $productRepository){}

    #[Route('/cart', name: 'app_cart', methods:['GET'])]
    public function index(SessionInterface $session, ProductRepository $productRepository, Cart $cart): Response
    {
        $data = $cart->getcart($session, $productRepository);
        //dd($total);
        
        return $this->render('cart/index.html.twig', [
            'items'=>$data['cart'],
            'total'=>$data['total']
            
        ]);
    }

    #[Route('/cart/add/{id}/', name: 'app_cart_new', methods:['GET'])]
    public function addToCart(int $id, SessionInterface $session):Response
    {
        $cart = $session->get('cart',[]);
        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1 ;
        }
        
        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}/', name: 'app_cart_product_remove', methods:['GET'])]
    public function removeToCart($id, SessionInterface $session):Response
    {
        $cart = $session->get('cart',[]);
        if(!empty($cart[$id])){
            unset($cart[$id]);

        }
        $session->set('cart',$cart);

        return $this->redirectToRoute('app_cart');
    }
    #[Route('/cart/remove/{id}/removeOne', name: 'app_cart_product_remove_one', methods:['GET'])]
    public function removeOneToCart($id, SessionInterface $session):Response
    {
        $cart = $session->get('cart',[]);
        if(!empty($cart[$id])){
            //unset($cart[$id]);

            $cart[$id] = $cart[$id] - 1;
        }
        $session->set('cart',$cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/', name: 'app_cart_remove', methods:['GET'])]
    public function removeCart(SessionInterface $session):Response
    {
        $session->set('cart',[]);
        $this->addFlash(
            'danger',
            'Votre panier a été supprimé'
         );

        return $this->redirectToRoute('app_cart');
    }
}
