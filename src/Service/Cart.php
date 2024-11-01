<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Cart
{
    public function getcart(SessionInterface $session, ProductRepository $productRepository):array
    {
        $cart = $session->get('cart',[]);
        $cartWithData = [];
        foreach ($cart as $id=>$quantity){
            $cartWithData[] = [
                'product'=>$productRepository->find($id),
                'quantity'=>$quantity

            ];
        }

        $total = array_sum(array_map(function ($item){
            return $item['product']->getPrice() * $item['quantity'];

        },$cartWithData));

        return [
            'cart'=>$cartWithData,
            'total'=>$total
        ];


    }
    
}