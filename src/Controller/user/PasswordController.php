<?php

namespace App\Controller\user;

use App\Entity\User;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class PasswordController extends AbstractController
{
    /**
     * @Route("/forgot_password", name="forgot.password", methods="GET|POST")
     * @param Request $request
     * @param Swift_Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     *
     * @return Response
     */
    public function forgotPassword(Request $request, Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        if ($request->isMethod('POST')) {

            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);

            if ($user === null) {
                $this->addFlash('error', 'E-mail non reconnu.');
                return $this->redirectToRoute('forgot.password');
            }
            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('home');
            }

            $url = $this->generateUrl('reset.password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Oublie de mot de passe - Réinisialisation'))
                ->setFrom('snowtricksocc@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'mail/resetPasswordMail.html.twig',
                        [
                            'user' => $user,
                            'url' => $url
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash('success', 'Vérifier vos mails afin de réinitialisé votre mot de passe.');

            return $this->redirectToRoute('home');
        }

        return $this->render('security/forgotpassword.html.twig');
    }

    /**
     * @Route("/reset_password/{token}", name="reset.password", methods="GET|POST")
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('error', 'Mot de passe non reconnu');
                return $this->redirectToRoute('home');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('plainpassword')));
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe mis à jour !');

            return $this->redirectToRoute('home');
        }else {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('error', 'Token invalide.');
                return $this->redirectToRoute('home');
            }

            return $this->render('security/resetpassword.html.twig', ['token' => $token]);
        }

    }
}
