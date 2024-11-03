<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class StripePayment
{

    private $redirectUrl;

    public function __construct()
    {
        Stripe::setApiKey($_SERVER['STRIPE_SECRET']);
        Stripe::setApiVersion('2024-10-28.acacia');
    }

    public function startPayment($cart, $shippingCost){

        $cartProducts = $cart['cart'];
        $products = [
            [
                'qte' => 1,
                'price' => $shippingCost,
                'name' => "frais de livraison"
            ]
        ];

        foreach ($cartProducts as $value){
            $productItem = [];
            $productItem['name'] = $value['product']->getName();
            $productItem['price'] = $value['product']->getPrice();
            $productItem['qte'] = $value['quantity'];
            $products[] = $productItem;
            
        }

        $session = Session::create([
            'line_items'=>[
                array_map(fn(array $product)=>[
                    'quantity'=>$product['qte'],
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' =>[
                            'name' => $product['name']
                        ],
                        'unit_amount' => $product['price']*100
                    ],
                ], $products)

                
            ],
            'mode'=>'payment',
            'cancel_url'=>'http://127.0.0.1:8000/pay/cancel',
            'success_url'=>'http://127.0.0.1:8000/pay/success',
            'billing_address_collection' => 'required',
            'shipping_address_collection' => [
                'allowed_countries' =>['FR','CM']
            ],
            'metadata'=>[

            ]
            

        ]);

        $this->redirectUrl = $session->url;
        //dd($cart);

    }

    public function getStripeRedirectUrl(){
        return $this->redirectUrl;
    }
}