<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\Lieu;
use App\Form\LieuFormType;
use App\Form\SortieFormType;
use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;

class SortieController extends AbstractController
{
    /**
     * @Route ("/sortie/insert",name="insert")
     */
    public function insert(Request $request , EntityManagerInterface $em):Response{
       $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieFormType::class, $sortie);
        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $em->persist($sortie);
            $em->flush();
        }

       $lieu = new Lieu();
        $lieuForm = $this->createForm(LieuFormType::class, $lieu);
        $lieuForm->handleRequest($request);
        if($lieuForm->isSubmitted() && $lieuForm->isValid()){
            $em->persist($lieu);
            $em->flush();
        }

        return $this->render('sortie/newSortie.html.twig',[
            'sortieForm'=>$sortieForm->createView(),
            'lieuForm'=>$lieuForm->createView()

        ]);
    }


    /**
     * @Route("/sortie/infosSup/{id}", name="infosLieu")
     */
    public function infosLieu(LieuRepository $repo,$id):Response{
        $lieu=$repo->find($id);

        return $this->json('{ "lat":'.$lieu->getLatitude().',"long":'.$lieu->getLongitude().' }');
    }




    /**
     * @Route ("/sortie/update/{id}",name="update")
     */
    public function update(Request $request,$id){
        return $this->render('sortie/newSortie.html.twig');
    }

    /**
     * @Route ("/sortie/delete/{id}",name="delete")
     */
    public function delete(Request $request,$id){
        return $this->render('sortie/newSortie.html.twig');
    }



}
