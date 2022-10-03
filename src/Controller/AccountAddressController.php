<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    /**
     * @Route("/compte/adresses", name="app_account_address")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="app_account_address_add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $address = new Adress();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $entityManager->persist($address);
            $entityManager->flush();
            return $this->redirectToRoute('app_account_address');
        }

        return $this->renderForm('account/address_form.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="app_account_address_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $address = $entityManager->getRepository(Adress::class)->find($id);
        //dd($address);

            if (!$address || $address->getUser() != $this->getUser()) {
                return $this->redirectToRoute('app_account_address');
            }

            $form = $this->createForm(AddressType::class, $address);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
                return $this->redirectToRoute('app_account_address');
            }

        return $this->renderForm('account/address_form.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="app_account_address_delete")
     */
    public function delete(EntityManagerInterface $entityManager, $id): Response
    {
        $address = $entityManager->getRepository(Adress::class)->find($id);
        //dd($address);

            if ($address && $address->getUser() == $this->getUser()) {  
                $entityManager->remove($address);  
                $entityManager->flush();
            }
        
            return $this->redirectToRoute('app_account_address');

    }
}
