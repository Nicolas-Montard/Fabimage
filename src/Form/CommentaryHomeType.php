<?php

namespace App\Form;

use App\Entity\CommentaryHome;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaryHomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                    'removePlugins' => 'resize',
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
                'attr' => [
                    'class' => 'description-widget rounded'
                ]
            ])
            ->add('contentEs', CKEditorType::class, [
                'required' => true,
                'config' => [
                    'removePlugins' => 'resize',
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
                'attr' => [
                    'class' => 'description-widget rounded'
                ]
            ])
            ->add('contentEt', CKEditorType::class, [
                'required' => true,
                'config' => [
                    'removePlugins' => 'resize',
                    'enterMode' => 'CKEDITOR.ENTER_BR'
                ],
                'attr' => [
                    'class' => 'description-widget rounded'
                ]
            ])
            ->add('authorFr', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ]
            ])
            ->add('authorEs', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ]
            ])
            ->add('authorEt', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommentaryHome::class,
        ]);
    }
}
