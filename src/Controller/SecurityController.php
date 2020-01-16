<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $password_encoder;

    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
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
}
