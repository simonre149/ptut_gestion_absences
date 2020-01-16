<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    private $iv;
    private $cipher;
    private $tag;
    private $key;

    public function tokenGeneration()
    {
        if (!$this->getUser()) return $this->redirectToRoute('login');

        $user = $this->getUser();
        $token = $user->getId() . "#" . $user->getUsername() . "#" . $user->getClassroomGroup() . "#" . $user->getName() . "#" . $user->getFirstname();
        $crypted_token = $token;

        /*
        $cipher = "aes-128-gcm";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $key = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

        $crypted_token = openssl_encrypt($token, $cipher, $key, 0, $iv, $tag);



        $this->cipher = $cipher;
        $this->iv = $iv;
        $this->tag = $tag;
        $this->key = $key;

        dd($crypted_token);*/

        return $this->render('pages/generatetoken.html.twig', [
            'crypted_token' => $crypted_token,
            'role' => $user->getRoles()
        ]);
    }

    public function tokenRefresh()
    {

        return $this->redirectToRoute('generate_token');
    }

    public function getUserFromToken(Request $request, UserRepository $userRepository)
    {
        $crypted_token = $request->get('token');

        /*
         $decrypted_token = openssl_decrypt($crypted_token, $this->cipher, $this->key, $options=0, $this->iv, $this->tag);

        if(strpos($crypted_token, ' '))
        {
            $crypted_token = str_replace(" ", "+", $crypted_token);
        }

        dump($crypted_token);
        dd($decrypted_token);*/

        $decrypted_token = $crypted_token;
        $user_id = $decrypted_token[0];

        $user = $userRepository->findUserArrayById($user_id);

        return new JsonResponse($user);
    }
}
