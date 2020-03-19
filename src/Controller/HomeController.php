<?php

namespace App\Controller;

use App\Repository\ClassroomRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index(ClassroomRepository $classroomRepository, UserRepository $userRepository)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $user_id = $this->getUser()->getId();
            $user = $userRepository->findUserById($user_id);

            $student_classrooms = '';
            $teacher_classrooms = '';
            $classrooms = '';

            if($user->getRoles() == ['ROLE_USER']) //si l'utilisateur est un élève
            {
                $student_classrooms = $classroomRepository->findAllByGroupId($user->getClassroomGroup());
            }

            if($user->getRoles() == ['ROLE_ADMIN']) //si l'utilisateur est un professeur
            {
                $teacher_classrooms = $classroomRepository->findAllByTeacherId($user_id);
            }
            if($user->getRoles() == ['ROLE_SUPER_ADMIN']) //si l'utilisateur est un admin
            {
                $classrooms = $classroomRepository->findAll();
            }
        }
        else
        {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        }

        return $this->render('pages/home.html.twig', [
            'role' => $user->getRoles(),
            'student_classrooms' => $student_classrooms,
            'teacher_classrooms' => $teacher_classrooms,
            'classrooms' => $classrooms,
            'user' => $user,
            'current_menu' => 'home'
        ]);
    }
}