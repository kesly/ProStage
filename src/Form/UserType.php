<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            //->add('roles')
            ->add('password', RepeatedType::class, [
              'type' => PasswordType::class,
              'invalid_message' =>"les mots de passe doivent etre identique",
              'options'=> ['attr'=> ['class'=>'password-field']],
              'required' =>true,
              'first_options' => ['label' => 'Mot de passe', 'attr'=> [ 'placeholder' => 'Votre mot de passe...']  ],
              'second_options' => ['label' => 'Confirmer mot de passe', 'attr'=> ['placeholder' => 'Votre mot de passe à nouveau...'] ]

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
