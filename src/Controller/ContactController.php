<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="app_contact")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Merci de nous avoir contacté. Nous vous répondrons dans les plus brefs délais.');

            // TODO envoyer un email à une adresse de notre choix, par exemple contact@laboutiquefrancaise.com ou connecter à un service externe comme , ZenDesk, SendGrid
            //dd($form->getData());
        }

        
        return $this->renderForm('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
