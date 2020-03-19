<?php

namespace App\Controller;

use App\Repository\AbsenceRepository;
use App\Repository\ClassroomRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Json;

class ApiController extends AbstractController
{
    public function tokenGeneration()
    {
        if (!$this->getUser()) return $this->redirectToRoute('login');

        $user = $this->getUser();
        $token = $user->getId() . "#" . $user->getUsername() . "#" . $user->getClassroomGroup() . "#" . $user->getName() . "#" . $user->getFirstname() . 'tok';

        return $this->render('pages/generatetoken.html.twig', [
            'token' => $token,
            'role' => $user->getRoles()
        ]);
    }

    public function handleData(Request $request, string $data_name)
    {
        if ($request->isMethod('POST'))
        {
            $array_of_data = json_decode($request->getContent(), true);
            $data = $array_of_data[$data_name];
        }
        else
        {
            return new JsonResponse(1);
        }

        return $data;
    }

    public function getUserFromToken(Request $request, UserRepository $userRepository)
    {
        $token = $this->handleData($request, 'token');
        $token_exploded = explode("#", $token);
        $user_id = $token_exploded[0];
        $user_array = $userRepository->findUserArrayById($user_id);
        $user_entity = $userRepository->findUserById($user_id);
        $user_array[0]['classroom_group'] = $user_entity->getClassroomGroup()->getName();

        return new JsonResponse($user_array);
    }

    public function getUserClassrooms(Request $request, UserRepository $userRepository, ClassroomRepository $classroomRepository)
    {
        $token = $this->handleData($request, 'token');
        $token_exploded = explode("#", $token);
        $user_id = $token_exploded[0];
        $user = $userRepository->findUserById($user_id);
        $user_classroom_group_id = $user->getClassroomGroup()->getId();
        $classrooms_entities_of_group = $classroomRepository->findAllByGroupId($user_classroom_group_id);
        $classrooms_array_of_group = [];

        $nb_classrooms = 0;
        foreach ($classrooms_entities_of_group as $classroom_entity)
        {
            $temp_classroom_array = [];
            array_push($temp_classroom_array, $classroom_entity->getId());
            array_push($temp_classroom_array, $classroom_entity->getName());
            array_push($temp_classroom_array, $classroom_entity->getTeacher()->getName() . " " . $classroom_entity->getTeacher()->getFirstname());
            array_push($temp_classroom_array, $classroom_entity->getStartAt()->format('d/m/Y H:i'));
            array_push($classrooms_array_of_group, $temp_classroom_array);
            $nb_classrooms++;
        }
        array_unshift($classrooms_array_of_group, $nb_classrooms);

        return new JsonResponse($classrooms_array_of_group);
    }

    public function removeUserFromAbsence(Request $request, UserRepository $userRepository, AbsenceRepository $absenceRepository, EntityManagerInterface $manager)
    {
        $token = $this->handleData($request, 'token');
        $token_exploded = explode("#", $token);
        $user_id = $token_exploded[0];
        $classroom_id = $this->handleData($request, 'classroomid');
        $absence = $absenceRepository->findOneByClassroomIdAndUserId($classroom_id, $user_id);

        if ($absence)
        {
            $manager->remove($absence);
            $manager->flush();
            return new JsonResponse(0);
        }
        else
        {
            return new JsonResponse(1);
        }
    }


    public function testApi(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $data = json_decode($request->getContent());
            $data = $data->data;

            return new JsonResponse('Test ok pour : ' . $data);
        }
        else
        {
            return $this->redirectToRoute('home');
        }
    }
}