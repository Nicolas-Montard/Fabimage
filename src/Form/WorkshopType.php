<?php

namespace App\Form;

use App\Entity\Commentary;
use App\Entity\Workshop;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class WorkshopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleFr', TextType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('titleEt', TextType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('titleEs', TextType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('descriptionFr', CKEditorType::class,[
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
            ->add('descriptionEs', CKEditorType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'description-widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
            ])
            ->add('descriptionEt', CKEditorType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'description-widget rounded text-area'
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
            ])
            ->add('pictureFile', VichFileType::class,[
                'required' => $options['image_required'],
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'mb-1'
                ],
            ])
            ->add('smallPictureFile', VichFileType::class,[
                'required' => $options['image_required'],
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'mb-1'
                ]
            ])
            ->add('duration', TextType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('minNbPlaces', NumberType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('maxNbPlaces', NumberType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('location', TextType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('optionalDescriptionFr', CKEditorType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'description-widget rounded text-area'
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
            ])
            ->add('optionalDescriptionEt', CKEditorType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'description-widget rounded text-area'
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
            ])
            ->add('optionalDescriptionEs', CKEditorType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'description-widget rounded text-area'
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workshop::class,
            'image_required' => true
        ]);
    }
}
