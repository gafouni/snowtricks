<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('trickName')
            ->add('description')
            ->add('imgFile')
            ->add('videoFile', FileType::class, 
            // [
            //     // 'label'=>'Video de la figure',
            //     // // 'mapped'=>false,
            //     // 'required'=>false,
            // ]
            )
            // ->add('slug')
            // ->add('createdAt')
            ->add('trickGroup')
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
