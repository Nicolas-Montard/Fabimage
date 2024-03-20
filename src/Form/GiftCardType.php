<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\Workshop;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class GiftCardType extends AbstractType
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
            ->add('type', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('postalCode', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('name', TextType::class, [
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
            ->add('beneficiaryName', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('phoneNumber', NumberType::class, [
                'label' => 'Numéro de télephone',
                'required' => true,
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('commentary', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'widget rounded message'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('isComing', CheckboxType::class, [
                'attr' => [
                    'class' => ''
                ],
                'label_attr' => [
                    'class' => 'ms-3'
                ]
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'locale' => $this->requestStack->getCurrentRequest()->getLocale(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
