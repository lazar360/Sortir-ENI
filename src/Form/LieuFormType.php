<?php

namespace App\Form;

use App\Entity\Lieu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('rue', EntityType::class,[
                'class'=>Lieu::class,
                'choice_label'=>function($lieu) {
                    return $lieu->getRue();
                }])
            ->add('latitude', EntityType::class,[
                'class'=>Lieu::class,
                'choice_label'=>function($lieu) {
                    return $lieu->getLatitude();
                }])
            ->add('longitude', EntityType::class,[
                'class'=>Lieu::class,
                'choice_label'=>function($lieu) {
                    return $lieu->getLongitude();
                }])

            //->add('ville')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
