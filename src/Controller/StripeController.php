<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\JsonResponse;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session", name="app_stripe_create_session")
     */
    public function index(Cart $cart): Response
    {

        $product_for_stripe = [];
        $YOUR_DOMAIN = 'http://localhost:8000';

        foreach ($cart->getFull() as $product){
            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product['product']->getPrice(),
                    'product_data' => [
                        'name' => $product['product']->getName(),
                        'images' => [$YOUR_DOMAIN."/uploads/".$product['product']->getIllustration()],
                    ],
                ],
                'quantity' => $product['quantity'],
            ];
        }

        Stripe::setApiKey('sk_test_51LptIoKlvmFaFBYE9EomiiChLMkV3n1y1d7z8R0VYyfcOXMAXTshNIx82TrsE3KRH3BKlcP2ZuEesvYQTnCz7veZ00Gy8iZ78k');

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                $product_for_stripe
                ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
            ]);

        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;

    }
}
