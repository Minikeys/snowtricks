<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use DateTime;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenGeneratorInterface $tokenGenerator
     *
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, TokenGeneratorInterface $tokenGenerator, Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form['email']->getData();
            $token = $tokenGenerator->generateToken();
            $gravatar = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email)));
            $user->setGravatar($gravatar);
            $user->setStatus(false);
            $user->setActivateToken($token);
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $url = $this->generateUrl('activate.account', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Activation de votre compte'))
                ->setFrom('snowtricksocc@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'mail/activateAccountMail.html.twig',
                        [
                            'user' => $user,
                            'url' => $url
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash('success', 'Votre compte a été créé, vérifier vos mails afin d\'activer votre compte');
            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activate_account/{token}", name="activate.account", methods="GET")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function activateAccount(Request $request)
    {
            $entityManager = $this->getDoctrine()->getManager();
            $token = $request->get('token');

            $user = $entityManager->getRepository(User::class)->findOneByActivateToken($token);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('error', 'Token invalide.');
                return $this->redirectToRoute('home');
            }

                $user->setActivateToken(null);
                $user->setDateActivate(new DateTime());
                $user->setStatus(true);
                $entityManager->flush();

                $this->addFlash('success', 'Votre compte est activé, vous pouvez vous connecter!');

                return $this->redirectToRoute('home');


    }
}
