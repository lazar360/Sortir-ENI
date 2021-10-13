<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSortie')
            ->add('dateHeureDebut')
            ->add('dateLimiteInscription')
            ->add('nbInscriptionMax')
            ->add('duree')
            ->add('infoSortie')
            ->add('site',EntityType::class,[ 'class'=>Site::class,
                'choice_label'=>function($site){
                    return $site->getNomSite();
                    }])
            ->add('lieu',EntityType::class,[ 'class'=>Lieu::class,
                'choice_label'=>function($lieu){
                    return $lieu->getNomLieu();
            }])

            //->add('etatSortie')
            /*->add('lieu',EntityType::class,[
                            'class'=>Lieu::class,
                            'choice_label'=>function($lieu){
                    return $lieu->getNomLieu();

                }])*/
          /*  ->add('',EntityType::class,[ 'class'=>Lieu::class,
                 'choice_label'=>function($lieu){
                     return $lieu->getLongitude();

                 }])*/
           /*->add('lieu',EntityType::class,[ 'class'=>Lieu::class,
                 'choice_label'=>function($lieu){
                     return $lieu->getLatitude();

                 }])
             ->add('lieu',EntityType::class,[ 'class'=>Lieu::class,
                 'choice_label'=>function($lieu){
                     return $lieu->getVille();

                 }])*/
            //->add('urlPhoto')

            /*->add('etat',EntityType::class,[ 'class'=>Etat::class,
                'choice_label'=>function($etat){
                    return $etat->getLibelle();
                }])*/

            //->add('organisateur')
            //->add('participant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
