<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Json;

class SecurityController extends AbstractController
{
    private $password_encoder;

    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->password_encoder = $encoder;
            $hashed_password = $this->password_encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashed_password);

            $role = $form->get('rolechoice')->getData();
            $student_group = $form->get('groupchoice')->getData();

            switch ($role)
            {
                case 'user':
                    $user->setRoles(['ROLE_USER']);
                    break;
                case 'admin':
                    $user->setRoles(['ROLE_ADMIN']);
                    break;
                case 'super-admin':
                    $user->setRoles(['ROLE_SUPER_ADMIN']);
                    break;
            }

            switch ($student_group)
            {
                case 'none':
                    $user->setStudentGroup('');
                    break;
                case 'A1':
                    $user->setStudentGroup('A1');
                    break;
                case 'A2':
                    $user->setStudentGroup('A2');
                    break;
                case 'B1':
                    $user->setStudentGroup('B1');
                    break;
                case 'B2':
                    $user->setStudentGroup('B2');
                    break;
            }

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        $role = $userRepository->findUserById($this->getUser())->getRoles();

        return $this->render('security/registration.html.twig', [
                'role' => $role,
                'form' => $form->createView(),
                'current_menu' => 'registration'
            ]);
    }

    public function login(AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser()) return $this->redirectToRoute('home');

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig',[
            'error' => $error,
        ]);
    }

    public function logout(){}

    public function testJson() : JsonResponse
    {
        return new JsonResponse('test');
    }

    public function jsonLogin() : JsonResponse
    {
        $user = $this->getUser();

        return new JsonResponse([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }
}
