<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="sortie")
     */
    public function index(): Response
    {
        return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    /**
     * @Route ("/sortie/insert",name="insert")
     */
    public function insert(Request $request , EntityManagerInterface $em):Response{
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class,$sortie);
        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $em->persist($sortie);
            $em->flush();
        }

        return $this->render('sortie/index.html.twig',[
            'sortieForm'=>$sortieForm->createView()
        ]);
    }


    /**
     * @Route ("/sortie/update/{id}",name="update")
     */
    public function update(Request $request,$id){
        return $this->render('sortie/index.html.twig');
    }

    /**
     * @Route ("/sortie/delete/{id}",name="delete")
     */
    public function delete(Request $request,$id){
        return $this->render('sortie/index.html.twig');
    }



}
