<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Site;
use App\Entity\Sortie;


use App\Form\SortieFormType;
use App\Repository\SortieRepository;
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
}
