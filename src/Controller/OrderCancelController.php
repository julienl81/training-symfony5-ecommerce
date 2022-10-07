<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCancelController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/commande/erreur/{stripeSessionId}", name="app_order_cancel")
     */
    public function index($stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        //dd($order);

        if(!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // envoyer un email à notre client pour lui dire que sa commande a échoué
        
        return $this->render('order_cancel/index.html.twig', [
            'order' => $order,
        ]);
    }
}
