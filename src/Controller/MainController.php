<?php

namespace App\Controller;


use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;


use App\Form\SortieFormType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request, SortieRepository $sr): Response
    {
        $sorties = $this->getDoctrine()->getRepository(Sortie::class)->findBy([], ['dateHeureDebut' => 'asc']);
        $sites = $this->getDoctrine()->getRepository(Site::class)->findAll();

        /*
        if(!empty($sites) && !empty('search')){
            $sr->findBySite('sites');
        }

        $entreeRecherchee  = $request->request->get('searchSortie');
        if(!empty($entreeRecherchee) && !empty('search')){
            $sr->findBySearch($entreeRecherchee);
        }*/
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'sorties'=>$sorties,
            'sites'=>$sites,
        ]);
    }


    /**
     * @Route("/index/selectSite/{id}", name="selectSite")
     */
    public function select(Request $request, SortieRepository $sr, $id): Response {

        $sortieList = $sr->findBy(["site"=>$id]);
             /*   dd($sortieList);*/
        $tab=[];
        foreach ($sortieList as $val){
            array_push($tab, [
                "nomSortie" => $val->getNomSortie(),
                "dateHeureDebut" => $val->getDateHeureDebut(),
                "dateLimiteInscription" => $val->getDateLimiteInscription(),
                "nbInscriptionMax" => $val->getNbInscriptionMax(),
                "etat"=>$val->getEtat()->getLibelle(),
                "organisateur"=>$val->getOrganisateur()->getNom(),
            ]);
        }
        return $this->json(json_encode($tab));

    }

    /**
     * @Route("/index/selectOrga/{bool}", name="selectOrga")
     */
    public function selectOrga(Request $request, SortieRepository $sr, $bool): Response {
        if($bool == "true"){
            $orgaList = $sr->findBy(["organisateur"=>$this->getUser()]);
           /* dd("1er if");*/
            $tab=[];
            foreach ($orgaList as $val){
                array_push($tab, [
                    "nomSortie" => $val->getNomSortie(),
                    "dateHeureDebut" => $val->getDateHeureDebut(),
                    "dateLimiteInscription" => $val->getDateLimiteInscription(),
                    "nbInscriptionMax" => $val->getNbInscriptionMax(),
                    "etat"=>$val->getEtat()->getLibelle(),
                    "organisateur"=>$val->getOrganisateur()->getNom(),
                ]);
            }
            return $this->json(json_encode($tab));
        }
        if($bool == "false") {
            $orgaList = $sr->findAll();
           /* dd("2eme if");*/
            $tab=[];
            foreach ($orgaList as $val){
                array_push($tab, [
                    "nomSortie" => $val->getNomSortie(),
                    "dateHeureDebut" => $val->getDateHeureDebut(),
                    "dateLimiteInscription" => $val->getDateLimiteInscription(),
                    "nbInscriptionMax" => $val->getNbInscriptionMax(),
                    "etat"=>$val->getEtat()->getLibelle(),
                    "organisateur"=>$val->getOrganisateur()->getNom(),
                ]);
            }
            return $this->json(json_encode($tab));
        }
    }

    /**
     * @Route("/index/selectDactylo/{val}", name="selectDactylo")
     */
    public function selectDactylo(Request $request, SortieRepository $sr, $val=""): Response {

        if (!$val == "" ){
             /*dd($val);*/
            $dactyloList = $sr->findByName($val);
             /* dd($dactyloList);*/
            $tab=[];
            foreach ($dactyloList as $val){
                array_push($tab, [
                    "nomSortie" => $val->getNomSortie(),
                    "dateHeureDebut" => $val->getDateHeureDebut(),
                    "dateLimiteInscription" => $val->getDateLimiteInscription(),
                    "nbInscriptionMax" => $val->getNbInscriptionMax(),
                    "etat"=>$val->getEtat()->getLibelle(),
                    "organisateur"=>$val->getOrganisateur()->getNom(),
                ]);
            }
            return $this->json(json_encode($tab));
        }

        if($val == "") {
    /*        dd($val);*/
            $dactyloList = $sr->findAll();
          /*  dd($dactyloList);*/
            $tab=[];
            foreach ($dactyloList as $val){
                array_push($tab, [
                    "nomSortie" => $val->getNomSortie(),
                    "dateHeureDebut" => $val->getDateHeureDebut(),
                    "dateLimiteInscription" => $val->getDateLimiteInscription(),
                    "nbInscriptionMax" => $val->getNbInscriptionMax(),
                    "etat"=>$val->getEtat()->getLibelle(),
                    "organisateur"=>$val->getOrganisateur()->getNom(),
                ]);
            }
            return $this->json(json_encode($tab));
        }
    }


}
