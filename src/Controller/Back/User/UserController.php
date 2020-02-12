<?php

namespace App\Controller\Back\User;

use App\Entity\User;
use App\Form\UserType;

use App\Form\AdminUserType;
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
* @IsGranted("ROLE_ADMIN_USERS")
* @Route("/admin/user")
*/
class UserController extends AbstractController
{
    /**
     * @Route("/list", name="admin_user_list")
     */
    public function list(UserRepository $u)
    {
        return $this->render('back/user/list.html.twig', [
            'users' => $u->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_user_new")
     * @Route("/edit/{id}", name="admin_user_edit")
     */
    public function AddEdit(User $u = null, Request $req, EntityManagerInterface $manager, Security $security, UserPasswordEncoderInterface $encoder)
    {
        if (!$u) {
            $u = new User();
        }

        $form = $this->createForm(AdminUserType::class, $u);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            $password = $form['password']->getData();
            if($password) {
                $encoded = $encoder->encodePassword($u, $password);
                $u->setPassword($encoded);
            }

            $manager->persist($u);
            $manager->flush();
            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('back/user/addEdit.html.twig', [
            'form' => $form->createView(),
            'editMode'  => $u->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_user_delete")
     */
    public function delete(User $u, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $manager->remove($u);
            $manager->flush();

            return $this->redirectToRoute('admin_user_list');
        }
    }
}
