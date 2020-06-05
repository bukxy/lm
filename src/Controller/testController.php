<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class testController extends AbstractController
{
    // /**
    //  * @Route("/encoder", name="encoder")
    //  */
    // public function profile(UserPasswordEncoderInterface $encoder)
    // {

    //     $user = new User;
    //     $plainPassword = 'xDz66VDj7';
    //     $encoded = $encoder->encodePassword($user, $plainPassword);

    //     return $this->render('front/encoder/encoder.html.twig', [
    //         'p' => $plainPassword,
    //         'r' => $encoded
    //     ]);
    // }
}
