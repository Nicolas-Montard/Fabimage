<?php

namespace App\Form;

use App\Entity\Commentary;
use App\Entity\Workshop;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('author', TextType::class, [
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
            'data_class' => Commentary::class,
        ]);
    }
}
