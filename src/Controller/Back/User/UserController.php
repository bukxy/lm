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

/**
* @Route("/admin/user")
*/
class UserController extends AbstractController
{
    /**
     * @Route("/", name="admin_user_list")
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
    public function AddEdit(User $u = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$u) {
            $u = new User();
        }

        $form = $this->createForm(UserType::class, $u);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // /**
    //  * @Route("/image/add/{id}", name="admin_construction_new_image")
    //  */
    // public function AddImage(User $c, Image $i = null, Request $req, EntityManagerInterface $manager, Security $security)
    // {
    //     if (!$i) {
    //         $i = new Image();
    //     }

    //     $formImg = $this->createForm(ImageType::class, $i);
    //     $formImg->handleRequest($req);

    //     if ($formImg->isSubmitted() && $formImg->isValid()){

    //         /** @var UploadedFile $brochureFile */
    //         $brochureFile = $formImg['name']->getData();

    //         // this condition is needed because the 'brochure' field is not required
    //         // so the PDF file must be processed only when a file is uploaded
    //         if ($brochureFile) {
    //             $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
    //             // this is needed to safely include the file name as part of the URL
    //             $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
    //             $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

    //             // Move the file to the directory where brochures are stored
    //             try {
    //                 $brochureFile->move(
    //                     $this->getParameter('image_folder'),
    //                     $newFilename
    //                 );
    //             } catch (FileException $e) {
    //                 // ... handle exception if something happens during file upload
    //             }
    //         }

    //         // updates the 'brochureFilename' property to store the PDF file name
    //         // instead of its contents

    //         $user = $security->getUser();

    //         $c->setImage($i);
    //         $i->setUser($user);

    //         $i->setName($newFilename);

    //         if ($formImg['alt']->getData() == null){
    //             $i->setAlt('Aucune information sur l\'image est disponible');
    //         }

    //         $manager->persist($c);
    //         $manager->persist($i);
    //         $manager->flush();
    //         return $this->redirectToRoute('admin_construction_list');
    //     }

    //     return $this->render('back/construction/AddEditImage.html.twig', [
    //         'formImg' => $formImg->createView(),
    //         'editMode'  => $c->getId() !== null
    //     ]);
    // }

    // /**
    //  * @Route("/image/delete/{id}", name="admin_construction_delete_image")
    //  */
    // public function deleteImage(User $c, ImageRepository $i, EntityManagerInterface $manager, Security $security) {
    //     if ($security->getUser()){
    //         $image = $i->findOneBy(['id' => $c->getImage()]);

    //         $path = 'uploads/images/'.$image->getName();

    //         if ($image && file_exists($path)){
    //             unlink($path);
    //             $c->setImage(null);
    //             $manager->remove($image);
    //             $manager->flush();
    //             return $this->redirectToRoute('admin_construction_list');
    //         }
    //     }
    // }
}
