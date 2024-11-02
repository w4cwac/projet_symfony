<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Order;
use App\Entity\OrderProducts;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Service\Cart;
use App\Service\StripePayment;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(Request $request, 
        SessionInterface $session, 
        ProductRepository $productRepository,
        EntityManagerInterface $entityManagerInterface,
        Cart $cart,
        StripePayment $stripePayment,
    ): Response
    {
        $data = $cart->getcart($session, $productRepository);

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 

            if ($order->isPayOnDelivery()){

                if (!empty($data['total'])){

                    $order->setTotalPrice($data['total']);
                    $order->setCreatedAt(new DateTimeImmutable());
                    $entityManagerInterface->persist($order);
                    $entityManagerInterface->flush();

                    foreach ($data['cart'] as $value){
                        $orderProduct = new OrderProducts();
                        $orderProduct->setOrder($order);
                        $orderProduct->setProduct($value['product']);
                        $orderProduct->setQte($value['quantity']);

                        $entityManagerInterface->persist($orderProduct);
                        $entityManagerInterface->flush();

                    }

                    $this->addFlash(
                        'success',
                        'Votre commande a été transmise'
                    );
    
                    return $this->redirectToRoute('app_home');
                }else{
                    $this->addFlash(
                        'danger',
                        'Votre panier ne comporte aucun article'
                    );
    
                    return $this->redirectToRoute('app_home');
                }

                $session->set('cart',[]);
                

                



            }

            $payment = new StripePayment();

            $shippingCost = $order->getCity()->getShippingCost();

            $payment->startPayment($data, $shippingCost);

            $stripeRedirectUrl = $payment->getStripeRedirectUrl();


            return $this->redirect($stripeRedirectUrl);

            
            
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'total'=>$data['total']
        ]);
    }

    #[Route('/city/{id}/shipping/cost', name: 'app_city_shipping_cost')]
    public function cityShippingCost(City $city): Response
    {
        $cityShippingPrice = $city->getShippingCost();

        return new Response(json_encode(['status'=>200, "message"=>'on', 'content'=>$cityShippingPrice]));


    }

    #[Route('/order/message', name: 'app_order_message')]
    public function orderMessage():Response
    {
        return $this->render('order/order_message.html.twig');
    }

    #[Route('/admin/order', name: 'app_orders_show')]
    public function getAllOrder(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findAll();
        
        return $this->render('order/order.html.twig',[
            'orders'=>$order
        ]);

    }
}
