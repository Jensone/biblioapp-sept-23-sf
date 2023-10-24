<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends AbstractController
{

    #[Route('payment/session', name: 'payment_session')]
    public function paymentSession(
        Request $request,
        OrderRepository $orderRepository
    ): RedirectResponse
    {
        Stripe::setApiKey($this->getParameter('STRIPE_SECRET_KEY'));

        $order = $orderRepository->findOneBy([
            'id' => $request->get('order')
        ]);


        foreach($order->getBooks() as $book){
            $bookTitle = $book->getTitle();
        }

        if($order){
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => $order->getTotal() * 100,
                        'product_data' => [
                            'name' => 'Réservation',
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $this->generateUrl('payment_success', ['order' => $order->getId()], 0),
                'cancel_url' => $this->generateUrl('payment_cancel', [], 0),
            ]);

            //
            return $this->redirect($checkout_session->url);
        }
    }

    #[Route('payment/success', name: 'payment_success')]
    public function paymentSuccess(
        Request $request,
        OrderRepository $orderRepository
    ): Response
    {
        $order = $orderRepository->findOneBy([
            'id' => $request->get('order')
        ]);
        $order->setStatut(true);
        return $this->render('payment/success.html.twig', [
            'order' => $order
        ]);
    }

    #[Route('payment/cancel', name: 'payment_cancel')]
    public function paymentCancel(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }
}
