<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;


class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameFr', TextType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('nameEs', TextType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('nameEt', TextType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('smallDescriptionFr', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded under-title'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('smallDescriptionEs', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded under-title'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('smallDescriptionEt', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded under-title'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('price', MoneyType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'divisor' => 100,
            ])
            ->add('pictureFrFile', VichFileType::class,[
                'required' => $options['image_required'],
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'mb-1'
                ],
            ])
            ->add('pictureEsFile', VichFileType::class,[
                'required' => $options['image_required'],
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'mb-1'
                ],
            ])
            ->add('pictureEtFile', VichFileType::class,[
                'required' => $options['image_required'],
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'mb-1'
                ],
            ])
            ->add('bookFrFile', VichFileType::class,[
                'required' => false,
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'mb-1'
                ],
            ])
            ->add('bookEsFile', VichFileType::class,[
                'required' => false,
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'mb-1'
                ],
            ])
            ->add('bookEtFile', VichFileType::class,[
                'required' => false,
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'mb-1'
                ],
            ])
            ->add('descriptionFr', CKEditorType::class,[
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
                    'class' => 'description-widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'config' => [
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
            ])
            ->add('emailFr', CKEditorType::class, [
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
            ->add('emailEs', CKEditorType::class, [
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
            ->add('emailEt', CKEditorType::class, [
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
            ->add('videoLinkFr', TextType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('videoLinkEt', TextType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('videoLinkEs', TextType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('videoPassword', TextType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'image_required' => true
        ]);
    }
}
