<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', PasswordType::class)
            ->add('name')
            ->add('firstname')
            ->add('rolechoice', ChoiceType::class, [
                'choices' => [
                    'Élève' => 'user',
                    'Professeur' => 'admin',
                    'Admin' => 'super-admin'
                ],
                'mapped' => false
            ])
            ->add('groupchoice', ChoiceType::class, [
                'choices' => [
                    'Aucun (professeur ou admin)' => 'none',
                    'A1' => 'A1',
                    'A2' => 'A2',
                    'B1' => 'B1',
                    'B2' => 'B2'
                ],
                'mapped' => false
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
