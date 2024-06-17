<?php

namespace App\Form;

use App\Entity\Service;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleFr', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('titleEs', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('titleEt', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('underTitleFr', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded under-title'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('underTitleEs', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded under-title'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('underTitleEt', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded under-title'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('descriptionFr', CKEditorType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'description-widget rounded',
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
            ])
            ->add('descriptionEs', CKEditorType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'description-widget rounded',
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
            ])
            ->add('descriptionEt', CKEditorType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'description-widget rounded',
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
            ])
            ->add('pictureFile', VichFileType::class, [
                'required' => $options['image_required'],
                'label' => 'Image de présentation',
                'attr' => [
                    'placeholder' => 'Ajouter un fichier',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
            'image_required' => true
        ]);
    }
}
