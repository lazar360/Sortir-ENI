<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\ParticipantPictureName;
use App\Form\EditUserType;
use App\Form\ParticipantPictureFileType;
use http\Client\Curl\User;
use Monolog\Handler\IFTTTHandler;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileUpdateController extends AbstractController
{
    /**
     * @Route("/profile/update/{id}", name="profile_update")
     */
    public function editUser (Request $request, Participant $user) :Response
    {
        $user= $this->getUser();

        $form = $this->createForm(EditUserType::class,$user);
        $form->handleRequest($request);

       /* $participantPicture = new  ParticipantPictureName();

        $participantPictureFileType = $this->createForm(ParticipantPictureFileType::class, $participantPicture);
        $participantPictureFileType ->handleRequest($request);*/

        $entityManager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Utilisateur modifié avec succès');
                return $this->redirectToRoute('main');
            }


        /*if ($participantPictureFileType->isSubmitted() && $participantPictureFileType->isValid()){

            $participantPictureFile = $participantPictureFileType->get('participantpicturename')->getData();
            //this condition is needed because the picture field is not required
            if ($participantPictureFile){
                $originalFilename =pathinfo($participantPictureFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = transliterator_transliterate(
                    'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
                    $originalFilename);

                $newFilename = $safeFilename.'-'.uniqid().'.'.$participantPictureFile->guessExtension();

                //move the file to the directory where pictures are stored
                try {
                    $participantPictureFile->move(
                        $this->getParameter('profilpic_directory'),
                        $newFilename
                    );
                } catch (FileException $e){
                    //handle exception if something happens during file upload
                }

                // updates the 'participantPictureFilename' property to store the PDF file name instead of its contents

                $participantPicture->setName($newFilename);

                $this->addFlash('success', 'La photo a été mise à jour');
                $entityManager ->persist($participantPicture);
                //TODO create set participantPicture
                $this ->getUser()->setPicture($participantPicture);
                $entityManager->flush();

                return $this->redirectToRoute('profile_update');
            }*/

        //}
        return $this->render('profile_update/index.html.twig', [
            'editUserType' => $form->createView(),
            /*'participantPictureFormView' => $participantPictureFileType->createView(),*/
            'user' => $user,
        ]);
    }
}
