<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\AdminClassroomType;
use App\Form\ClassroomType;
use App\Form\TeacherClassroomType;
use App\Repository\ClassroomRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ClassroomController extends AbstractController
{
    public function addClassroom(Request $request, ObjectManager $manager, UserRepository $userRepository)
    {
        $user = $userRepository->findUserById($this->getUser());

        $classroom = new Classroom();

        if ($user->getRoles() == ['ROLE_ADMIN']) //si le user est un professeur
        {
            $classroom->setTeacher($user);
            $form = $this->createForm(TeacherClassroomType::class, $classroom);
        }
        else if ($user->getRoles() == ['ROLE_SUPER_ADMIN'])
        {
            $form = $this->createForm(AdminClassroomType::class, $classroom);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $student_group = $form->get('groupchoice')->getData();

            switch ($student_group)
            {
                case 'promocomp':
                    $classroom->setStudentGroup('promocomp');
                    break;
                case 'TDA':
                    $classroom->setStudentGroup('TDA');
                    break;
                case 'TDB':
                    $classroom->setStudentGroup('TDB');
                    break;
                case 'A1':
                    $classroom->setStudentGroup('A1');
                    break;
                case 'A2':
                    $classroom->setStudentGroup('A2');
                    break;
                case 'B1':
                    $classroom->setStudentGroup('B1');
                    break;
                case 'B2':
                    $classroom->setStudentGroup('B2');
                    break;
            }

            $manager->persist($classroom);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('pages/add.classroom.html.twig', [
            'role' => $user->getRoles(),
            'form' => $form->createView(),
            'current_menu' => 'add_classroom'
        ]);
    }

    public function editClassroom($classroom_id, ClassroomRepository $classroomRepository, Request $request)
    {
        $user = $this->getUser();
        $classroom = $classroomRepository->findByOneById($classroom_id);

        if ($user->getRoles() == ['ROLE_ADMIN']) //si le user est un professeur
        {
            if ($user->getId() != $classroom->getTeacher()->getId()) return $this->redirectToRoute('home'); //Sécurité
            $form = $this->createForm(TeacherClassroomType::class, $classroom);
        }
        else if ($user->getRoles() == ['ROLE_SUPER_ADMIN']) //si le user est un admin
        {
            $form = $this->createForm(AdminClassroomType::class, $classroom);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('pages/edit.classroom.html.twig', [
            'form' => $form->createView(),
            'role' => $user->getRoles(),
            'current_menu' => 'edit_classroom'
        ]);
    }

    public function showQrCode($classroom_id, ClassroomRepository $classroomRepository)
    {
        $classroom = $classroomRepository->findByOneById($classroom_id);

        return $this->render('pages/showqrcode.classroom.html.twig', [
            'classroom' => $classroom,
            'current_menu' => 'home',
            'role' => $this->getUser()->getRoles()
        ]);
    }

    public function validateManually($classroom_id)
    {
        dd("ATTENTION");
        if ($this->getUser()->getRoles() == ['ROLE_USER']) $this->redirectToRoute('home');

        return $this->render('pages/validatemanually.html.twig' ,[
            'current_menu' => 'validate_manually',
            'role' => $this->getUser()->getRoles()
        ]);
    }
}









