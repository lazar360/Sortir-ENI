<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use App\Repository\PartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailProfileController extends AbstractController
{

    /**
     * @Route("/profile/{id}", name="detail", requirements={"id":"\d+"})
     * @param $id
     * @param EntityManagerInterface $emi
     * @return Response
     */
    public function detail($id, EntityManagerInterface $emi)
    {
        $user = $emi->getRepository(Participant::class)->find($id);
        if ($user==null){
            throw $this ->createNotFoundException("Le particiant est absent de la base de données.");
        }

            return $this->render('detail_profile/index.html.twig', [
                'participant' => $user
        ]);
    }

}
