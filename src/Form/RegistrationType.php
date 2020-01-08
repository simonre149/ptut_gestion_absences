<?php

namespace App\Form;

use App\Entity\ClassroomGroup;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('classroomGroup', EntityType::class, [
                'class' => ClassroomGroup::class,
                'choice_label' => 'name',
                'required' => false
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
