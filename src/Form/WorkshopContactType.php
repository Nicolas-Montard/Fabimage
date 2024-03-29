<?php

namespace App\Form;

use App\Entity\Workshop;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class WorkshopContactType extends AbstractType
{
    private $requestStack;
    private $translator;

    public function __construct(RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->requestStack = $requestStack;
        $this->translator = $translator;
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
            ])
            ->add('comingWithFriend', TextType::class, [
                'required' => false,
                'label' => $this->translator->trans('contact.form.ComingWithFriend'),
                'attr' => [
                    'class' => 'widget rounded'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'locale' => $this->requestStack->getCurrentRequest()->getLocale(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

    }
}
