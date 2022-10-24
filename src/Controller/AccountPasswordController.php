<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class AccountPasswordController extends AbstractController
{
    /**
     * @Route("/compte/modifier-mon-mot-passe", name="app_account_password")
     * @isGranted("ROLE_ADMIN")
     */
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $notification = null;
     
        // recuperer le user connecté à envoyer au formulaire pour avoir son mot de passe et ses infos
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();
            //dd($old_pwd);

            /** @var User $user */
            if ($userPasswordHasher->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                //dd($new_pwd);
                $new_pwd =$userPasswordHasher->hashPassword($user, $new_pwd);

                $user->setPassword($new_pwd);

                $entityManager->flush();
                $notification = "Votre mot de passe à bien été mis à jour";
            } else {
                $notification = "Votre mot de passe actuel n'est pas le bon";
            }
        }

        return $this->renderForm('account/password.html.twig', [
            'form' => $form,
            'notification' => $notification
        ]);
    }
}
