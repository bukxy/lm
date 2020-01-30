<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserAccountActivation;

use App\Form\RegistrationFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager,\Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Création d'un code pour l'activation du compte + l'envoi du mail

            $code = bin2hex(random_bytes(60));

            $activationEntity = new UserAccountActivation;
                $activationEntity->setCode($code);
                $activationEntity->setStatus(0);

            $activationEntity->setUser($user);

            $user->setActivation($activationEntity);
            $manager->persist($activationEntity);
            $manager->persist($user);
            $manager->flush();

            $message = (new \Swift_Message('LordsMobile.com Registration Mail'))
                ->setFrom('noreply@lordsmobile.com')
                ->setTo($form->get('email')->getData())
                ->setBody(
                    $this->renderView('emails/registration.html.twig', [
                        'pseudo' => $form->get('pseudo')->getData(),
                        'email' => $form->get('email')->getData(),
                        'code' => $code,
                        ]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);

            $this->addFlash('success', 'Un mail pour l\'activation de votre compte vous a été envoyer');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activation/{pseudo}/{code}", name="app_activation")
     */
    public function activation(User $u, UserAccountActivation $c, Request $request, EntityManagerInterface $manager,\Swift_Mailer $mailer): Response
    {
        if ($c->getStatus() === false) {
            if ($u->getActivation() === $c) {
                $c->setStatus(true);
                $manager->persist($c);
                $manager->flush();
                $this->addFlash('success', 'Activation du compte réussi, vous pouvez vous connecter');
                return $this->redirectToRoute('app_login');
            }
        } else {
            $this->addFlash('error', 'Compte déjà activé...');
            return $this->redirectToRoute('app_login');
        }
    }
}
