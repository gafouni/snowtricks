<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('trickName')            
            ->add('description')                
            ->add('images', FileType::class, [
                'label'=> false,
                'multiple'=> true,
                'mapped'=> false,
                'required'=> false,
                'constraints'=> [
                    'mimeTypes' => [
                        'image/gif',
                        'image/jpeg',
                        'image/jpg',
                    ],
                    'mimeTypesMessage' => 'Veuillez selectionner un format d\'image valide'
                ]
            ])
            ->add('videos', CollectionType::class, [
                'entry_type'=>VideoType::class,
                'entry_options' => ['label' => false],
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                //'prototype'    => true,
                //'required' => false
            ]
                
            )           
            ->add('trickGroup')  
            // ->add('Ajouter', SubmitType::class)          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
