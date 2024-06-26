<?php

namespace App\Form;

use App\Entity\FollowUpEmail;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class FollowUpEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('subjectFr', TextType::class,[
            'required' => true,
            'attr' => [
                'class' => 'widget rounded'
            ],
            'label_attr' => [
                'class' => 'label'
            ]
        ])
        ->add('subjectEs', TextType::class,[
            'required' => true,
            'attr' => [
                'class' => 'widget rounded'
            ],
            'label_attr' => [
                'class' => 'label'
            ]
        ])
        ->add('subjectEt', TextType::class,[
            'required' => true,
            'attr' => [
                'class' => 'widget rounded'
            ],
            'label_attr' => [
                'class' => 'label'
            ]
        ])
        ->add('contentFr', CKEditorType::class, [
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
        ->add('contentEs', CKEditorType::class, [
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
        ->add('contentEt', CKEditorType::class, [
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
        ->add('sendAfter', NumberType::class, [
            'required' => true,
            'scale' => 0,
            'attr' => [
            'class' => 'number-widget rounded'
            ],
            'label_attr' => [
                'class' => 'label'
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FollowUpEmail::class,
        ]);
    }
}
