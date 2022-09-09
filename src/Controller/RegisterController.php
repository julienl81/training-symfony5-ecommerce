<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_register")
     */
    public function index(): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
    
        return $this->renderForm('register/index.html.twig', [
            'form' => $form
        ]);
    }
}


// return $this->renderForm('back/user/new.html.twig', [
//     'user' => $user,
//     'form' => $form,
// ]);