<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValidateManuallyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('users', EntityType::class, [
                'label' => 'Élèves',
                'class' => User::class,
                'query_builder' => function (UserRepository $er)
                {
                    $role = ['ROLE_USER'];
                    return $er->createQueryBuilder('u')
                        ->where('u.roles = :role')
                        ->setParameter('role', $role)
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
