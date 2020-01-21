<?php

namespace App\Controller\Back\User;

use App\Entity\User;
use App\Form\UserType;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_ADMIN_ACCESS")
* @Route("/admin")
*/
class UserAccountController extends AbstractController
{
    /**
     * @Route("/profile", name="admin_user_profile")
     */
    public function profile(EntityManagerInterface $manager, Request $req, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            $password = $form['password']->getData();

            if($password) {
                $encoded = $encoder->encodePassword($user, $password);
                $user->setPassword($encoded);
            }
            
            $manager->persist($user);
            $manager->flush();
            // return $this->redirectToRoute('admin_user_profile');
            return $this->render('back/user/profile.html.twig', [
                'form'  => $form->createView()
            ]);
        }

        return $this->render('back/user/profile.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}
