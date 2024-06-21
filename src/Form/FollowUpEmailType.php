<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\FollowUpEmail;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FollowUpEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('sendAfter')
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'id',
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
