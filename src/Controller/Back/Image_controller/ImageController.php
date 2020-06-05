<?php

namespace App\Controller\Back\Image_controller;

use App\Entity\Image;
use App\Form\ImageType;

use App\Entity\ImageCat;

use App\Repository\ImageRepository;
use App\Repository\ImageCatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_ADMIN_IMAGES")
* @Route("/admin/image")
*/
class ImageController extends AbstractController
{
    /**
     * @Route("/", name="admin_image_list")
     */
    public function listImage(ImageRepository $i)
    {
        return $this->render('back/image/imageList.html.twig', [
            'images' => $i->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_image_new")
     * @Route("/edit/{id}", name="admin_image_edit")
     */
    public function AddEditImage(Image $i = null,ImageCatRepository $catRepo, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$i) {
            $i = new Image();
        } else {
            $nameFile = $i->getName();
        }

        $form = $this->createForm(ImageType::class, $i);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form['name']->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('image_folder'),
                        $newFilename
                    );
                    if($i->getName()){
                        unlink('uploads/images/'.$nameFile);
                    }
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents

            $user = $security->getUser();

            $i->setUser($user);

            if ($brochureFile) {
                $i->setName($newFilename);
            } else {
                $i->setName($nameFile);
            }

            if ($form['alt']->getData() == null){
                $i->setAlt('Aucune description de l\'image');
            }

            $manager->persist($i);
            $manager->flush();
            return $this->redirectToRoute('admin_image_list');
        }

        return $this->render('back/image/imageAddEdit.html.twig', [
            'formImage' => $form->createView(),
            'editMode'  => $i->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_image_delete")
     */
    public function deleteImage(Image $i,ImageCatRepository $cat, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            if ($i) {
                unlink('uploads/images/'.$i->getName());
                $manager->remove($i);
                $manager->flush();
            }
            return $this->redirectToRoute('admin_image_list');
        }
    }
}
