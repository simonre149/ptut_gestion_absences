<?php

namespace App\Controller;

use App\Repository\AbsenceRepository;
use App\Repository\ClassroomRepository;
use App\Repository\UserRepository;
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
            return $this->redirectToRoute('home');
        }

        return $data;
    }

    public function getUserFromToken(Request $request, UserRepository $userRepository)
    {
        $token = $this->handleToken($request);
        $token_exploded = explode("#", $token);
        $user_id = $token_exploded[0];
        $user_array = $userRepository->findUserArrayById($user_id);
        $user_entity = $userRepository->findUserById($user_id);
        $user_array[0]['classroom_group'] = $user_entity->getClassroomGroup()->getName();

        return new JsonResponse($user_array);
    }

    public function getUserClassrooms(Request $request, UserRepository $userRepository, ClassroomRepository $classroomRepository)
    {
        $token = $this->handleToken($request);
        $token_exploded = explode("#", $token);
        $user_id = $token_exploded[0];
        $user = $userRepository->findUserById($user_id);
        $user_classroom_group_id = $user->getClassroomGroup()->getId();
        $classrooms_of_group = $classroomRepository->findAllByGroupId_Array($user_classroom_group_id);

        return new JsonResponse($classrooms_of_group);
    }

    public function removeUserFromAbsence(Request $request, UserRepository $userRepository, AbsenceRepository $absenceRepository)
    {
        if ($request->isMethod('POST'))
        {
            $token = $this->handleData($request, 'token');
            $classroom_id = $this->handleData($request, 'classroomid');
            //$absence = $absenceRepository->
        }
        else
        {
            return $this->redirectToRoute('home');
        }

        return $token;
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