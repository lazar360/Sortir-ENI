<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/admin/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new Participant();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user
                ->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // set ROLE : USER TODO add test role_admin Maybe in entity class
            $user->setRoles(["ROLE_USER"]);
            $entityManager = $this->getDoctrine()->getManager();

            //Création du chemin d'enregistrement de picture
            $path = $this->getParameter('kernel.project_dir').'/public/images';

            //Récupération des valeurs soumises sous forme d'objet User
            $user = $form->getData();

            //Récupération de picture
            $picture = $user->getPicture();

            //Récupération du file soumis
            $file = $picture->getFile();

            // Création d'un nom unique
            $name = md5(uniqid()).'.'.$file->guessExtension();

            // Déplacement du fichier
            $file->move($path, $name);

            //Donner le nom à picture
            $picture->setName($name);

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash("success", "Nouvel utilisateur enregistré(e).");
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
