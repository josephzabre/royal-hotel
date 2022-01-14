<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Messages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('expediteur',TextType::class , ['attr' =>[
                'placeholder'=>'entrez votre nom',
                'class'=>'form-control'
            ]
            ])
            ->add('mail', EmailType::class, ['attr' =>[
                'placeholder'=>'entrez votre addresse mail',
            'class'=>'form-control']
            ])
            ->add('message', TextareaType::class, ['attr' =>[
                'placeholder'=>'entrez votre message',
                'class'=>'form-control'
            ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
