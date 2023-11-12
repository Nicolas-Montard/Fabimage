<?php

namespace App\Form;

use App\Entity\Tariff;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class TariffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pictureFile', VichFileType::class, [
                'required' => $options['image_required'],
                'label' => 'Image de présentation',
                'attr' => [
                    'placeholder' => 'Ajouter un fichier',
                ]
            ])
            ->add('titleFr', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ]
            ])
            ->add('titleEs', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ]
            ])
            ->add('titleEt', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ]
            ])
            ->add('contentFr', CKEditorType::class, [
                'required' => true,
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
                'attr' => [
                    'class' => 'description-widget rounded'
                ]
            ])
            ->add('contentEs', CKEditorType::class, [
                'required' => true,
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
                'attr' => [
                    'class' => 'description-widget rounded'
                ]
            ])
            ->add('contentEt', CKEditorType::class, [
                'required' => true,
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
                'attr' => [
                    'class' => 'description-widget rounded'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tariff::class,
            'image_required' => true
        ]);
    }
}
