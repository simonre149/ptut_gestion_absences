<?php

namespace App\Form;

use App\Entity\Classroom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherClassroomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('start_at')
            ->add('end_at')
            ->add('groupchoice', ChoiceType::class, [
                'choices' => [
                    'Promotion complète' => 'promocomp',
                    'TD A' => 'TDA',
                    'TD B' => 'TDB',
                    'A1' => 'A1',
                    'A2' => 'A2',
                    'B1' => 'B1',
                    'B2' => 'B2'
                ],
                'mapped' => false
            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Classroom::class,
        ]);
    }
}
