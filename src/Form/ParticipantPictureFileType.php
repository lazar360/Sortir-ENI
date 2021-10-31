<?php

namespace App\Form;

use App\Entity\ParticipantPictureName;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantPictureFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('file', FileType::class)
            /*->add('name', FileType::class, [
                'label' => false,

                //unmapped means that this field is not associated to any entity proprerty
                'mapped' => false,

                //make it optional so you don't have to re-upload the PDF file
                // every time you edit the Participant Profil.
                //A default image will be displayed.
                'required' => false,
            ])*/

//            ->add('participant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParticipantPictureName::class,
        ]);
    }
}
