<?php

namespace App\Controller;

use App\Entity\Rejoindre;
use App\Entity\Sortie;
use App\Entity\Lieu;
use App\Entity\Ville;
use App\Entity\Site;
use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Monolog\Handler\IFTTTHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailSortieController extends AbstractController
{
    /**
     * @Route("sortie/{id}", name="detail_sortie", requirements={"id":"\d+"})
     * @param $id
     * @param EntityManagerInterface $emi
     * @return Response
     */
    public function detailSortie ($id, EntityManagerInterface $emi)
    {
        $sortie = $emi->getRepository(Sortie::class)->find($id);

        $lieu = $emi->getRepository(Lieu::class)->find($id);

        $participant = $emi->getRepository(Participant::class)->find($id);

        if ($sortie ==null){
            throw $this ->createNotFoundException("La sortie est absente de la base de données.");
        }
        return $this->render('detail_sortie/index.html.twig', [
           'infosSortie' => $sortie,
            'infosLieu'=>$lieu,
            'infosParticipant'=>$participant
        ]);
    }

    /**
     * @Route ("/rejoindre_sortie/{id}", name="rejoindre_sortie")
     * @param EntityManagerInterface $emi
     * @param Sortie $sortie
     */
    public function rejoindre (EntityManagerInterface $emi, Sortie $sortie){

        //TODO vérifier si le participant est déjà inscrit, créer nombre d'inscrits et vérifier si le nombre max est atteint
        // Ajouter un participant à la sortie
        $rejoindre = new Rejoindre();

        $rejoindre->setSonParticipant($this->getUser());

        $rejoindre->setSaSortie($sortie);

        $rejoindre->setDateInscription(new \DateTime());

        //sauvegarder les données en base
        $emi->persist($rejoindre);
        $emi->flush();

        $this->addFlash('success', 'Participant inscrit à la sortie');

        return $this->redirectToRoute('main');

    }

    /**
     * @Route ("/desister_sortie/{id}", name="desister_sortie")
     * @param EntityManagerInterface $emi
     * @param Sortie $sortie
     */
    public function desister (EntityManagerInterface $emi, Sortie $sortie){

        //récupérer la sortie en base de données et...
        $sortieRepo = $this->getDoctrine()
            ->getRepository(Rejoindre::class)
            ->findOneBy(['sonParticipant'=>$this->getUser(), 'saSortie'=>$sortie]);

        //l'annuler en base de données
        $emi ->remove($sortieRepo);
        $emi->flush();

        $this->addFlash('success', 'Sortie annulée');

        return $this->redirectToRoute('main');
    }

}



