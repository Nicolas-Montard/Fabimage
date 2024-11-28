<?php

namespace App\Form;

use App\Entity\Marquee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarqueeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contentFr', TextType::class, [
                'attr' => [
                    'class' => 'widget rounded',
                    'maxlength' => 255
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'required' => false,
            ])
            ->add('contentEs', TextType::class, [
                'attr' => [
                    'class' => 'widget rounded',
                    'maxlength' => 255
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'required' => false,
            ])
            ->add('contentEt', TextType::class, [
                'attr' => [
                    'class' => 'widget rounded',
                    'maxlength' => 255
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Marquee::class,
        ]);
    }
}
