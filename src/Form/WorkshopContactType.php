<?php

namespace App\Form;

use App\Entity\Workshop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkshopContactType extends AbstractType
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $locale = $this->requestStack->getCurrentRequest()->getLocale();
        if ($locale == 'fr'){
            $choiceLabel = 'titleFr';
        } elseif ($locale == 'es'){
            $choiceLabel = 'titleEs';
        } else{
            $choiceLabel = 'titleEt';
        }

        $builder
            ->add('workshop', EntityType::class, [
                'class' => Workshop::class,
                'choice_label' => $choiceLabel,
                'multiple'=> true,
                'expanded'=> true,
                'required' => true,
                'attr' => [
                    'class' => 'mt-1 workshop-checkbox'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('firstName', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('phoneNumber', NumberType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('message', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'widget rounded message'
                ],
                'label_attr' => [
                    'class' => 'label',
                    'choice_label' => 'title'
                ]
            ])
            ->add('informed', ChoiceType::class, [
                'choices' => [
                    'contact.form.informed.searchEngine' => 'Moteur de recherche sur Internet',
                    'contact.form.informed.facebook' => 'Facebook',
                    'contact.form.informed.instagram' => 'Instagram',
                    'contact.form.informed.friend' => 'Recommandation d\'un ami',
                    'contact.form.informed.other' => 'Autre',
                ],
                'choice_translation_domain' => 'messages',
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('agreements', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'label ms-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

    }
}
