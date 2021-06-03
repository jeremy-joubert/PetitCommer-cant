<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/admin84f681f48e51d/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/admin84f681f48e51d/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/admin84f681f48e51d/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));

            //generation du token d'activation du compte
            $user->setActivationToken(md5(uniqid()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            //envoie du email
            $message = (new \Swift_Message("Validation de votre compte"))
                ->setFrom('1christophejoubert@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('security/confirmation_email.html.twig', [
                        'token' => $user->getActivationToken()
                    ]),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash('message', 'Un email de validation vous a été envoyé!');

            return $this->redirectToRoute('index');

        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
            'titre' => 'Inscription'
        ]);
    }

    /**
     * @Route("/admin84f681f48e51d/activation/{token}", name="activation")
     */
    public function activation($token, UserRepository $repository, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, Request $request): Response
    {
        //on cherche le user avec ce token
        $user=$repository->findOneBy(['activationToken'=>$token]);

        //on verifi si le token existe
        if(!$user){
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas!');
        }

        //on suprime le token pour activer le compte
        $user->setActivationToken("");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte est bien activé ;)');

        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
        );
    }
}
