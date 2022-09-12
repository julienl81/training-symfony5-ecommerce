<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_register")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $hashedPassword = $userPasswordHasher->hashPassword($user,$user->getPassword());
            $user->setPassword($hashedPassword);

            //dd($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();
        }

    
        return $this->renderForm('register/index.html.twig', [
            'form' => $form
        ]);
    }
}


// return $this->renderForm('back/user/new.html.twig', [
//     'user' => $user,
//     'form' => $form,
// ]);