<?php

namespace App\Form;

use App\Entity\PromotionalCode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionalCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PromotionalCode::class,
        ]);
    }
}
