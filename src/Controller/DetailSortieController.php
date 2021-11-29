<?php

namespace App\Controller;

use App\Entity\Etat;
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
     *
     * Afficher le détail d'une sortie
     *
     * @Route("sortie/{id}", name="detail_sortie", requirements={"id":"\d+"})
     * @param $id
     * @param EntityManagerInterface $emi
     * @return Response
     */
    public function detailSortie ($id, EntityManagerInterface $emi)
    {
        $sortie = $emi->getRepository(Sortie::class)->find($id);

        $rejoindre = $emi->getRepository(Rejoindre::class)->findAll();

        $lieu = $emi->getRepository(Lieu::class)->find($id);

        $sonParticipant = $emi->getRepository(Rejoindre::class)->find($id);


        if ($sortie ==null){
            throw $this ->createNotFoundException("La sortie est absente de la base de données.");
        }
        return $this->render('detail_sortie/index.html.twig', [
            'infosSortie' => $sortie,
            'infosLieu'=>$lieu,
            'infosParticipant'=>$sonParticipant,
            'rejoindre'=>$rejoindre,
        ]);
    }

    /**
     *
     * Permet de s'inscrire à une sortie
     *
     * @Route ("/rejoindre_sortie/{id}", name="rejoindre_sortie")
     * @param EntityManagerInterface $emi
     * @param Sortie $sortie
     */
    public function rejoindre(EntityManagerInterface $emi, Sortie $sortie){

        $sortieRepo = $this->getDoctrine()->getRepository(Rejoindre::class)->findOneBy(['sonParticipant'=>$this->getUser(), 'saSortie'=>$sortie]);

        // Test si le participant est déjà inscrit
        if ($sortieRepo!==null){
            $this->addFlash('alert', 'Participant déjà inscrit à la sortie');

            return $this->redirectToRoute('main');
        }

        $rejoindre = new Rejoindre();

        $rejoindre->setSonParticipant($this->getUser());

        // Test si le nombre max est atteint et cloture la sortie
        $sortie->setNbInscrits($sortie->getNbInscrits()+1);
        if ($sortie->getNbInscrits() == $sortie->getNbInscriptionMax()){
            $etatCloturee = $emi -> getRepository(Etat::class)->findOneBy(['libelle'=>'clôturée']);
            $sortie->setEtat($etatCloturee);
        }

        $rejoindre->setSaSortie($sortie);

        $rejoindre->setDateInscription(new \DateTime());

        //sauvegarder les données en base
        $emi->persist($rejoindre);
        $emi->flush();

        $this->addFlash('success', 'Participant inscrit à la sortie');

        return $this->redirectToRoute('main');

    }

    /**
     *
     * Permet à un participant de se désister d'une sortie
     *
     * @Route ("/desister_sortie/{id}", name="desister_sortie")
     * @param EntityManagerInterface $emi
     * @param Sortie $sortie
     */
    public function desister (EntityManagerInterface $emi, Sortie $sortie){

        //récupérer la sortie en base de données et...
        $sortieRepo = $this->getDoctrine()
            ->getRepository(Rejoindre::class)
            ->findOneBy(['sonParticipant'=>$this->getUser(), 'saSortie'=>$sortie]);

        //Test si le participant est inscrit à la sortie
        if ($sortieRepo !==null){

            // Soustraire un participant
            $sortie->setNbInscrits($sortie->getNbInscrits()-1);

        //l'annuler en base de données
        $emi ->remove($sortieRepo);
        $emi->flush();

            $this->addFlash('success', 'Participation à la sortie annulée');

            return $this->redirectToRoute('main');

        }else{

            $this->addFlash('alert', "Participant non inscrit à la sortie");

            return $this->redirectToRoute('main');


        }
    }

}



