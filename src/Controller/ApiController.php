<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    public function getUserFromToken(Request $request, UserRepository $userRepository)
    {
        $token = $request->get('token');
        $user = $userRepository->findUserByToken($token);

        return new JsonResponse($user);
    }
}
