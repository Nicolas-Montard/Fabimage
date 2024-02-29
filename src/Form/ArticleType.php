<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ArticleType extends AbstractType
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
            ->add('titleEs', TextType::class,[
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
            ->add('summaryFr', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded under-title'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('summaryEs', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded under-title'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('summaryEt', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded under-title'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('contentFr', CKEditorType::class,[
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
            ->add('contentEs', CKEditorType::class,[
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
            ->add('contentEt', CKEditorType::class,[
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
            ->add('createdAt', DateType::class,[
                'widget' => 'choice'
            ])
            ->add('isActive', CheckboxType::class, [
                'required' => false
            ])
            ->add('pictureFile', VichFileType::class, [
                'required' => $options['image_required'],
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'mb-1'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'image_required' => true
        ]);
    }
}
