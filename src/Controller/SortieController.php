<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\Lieu;
use App\Form\LieuFormType;
use App\Form\SortieFormType;
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
