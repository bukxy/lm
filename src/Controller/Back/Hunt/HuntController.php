<?php

namespace App\Controller\Back\Hunt;

use App\Entity\Image;
use App\Entity\Hunt;
use App\Entity\HuntCat;

use App\Form\ImageType;
use App\Form\HuntType;
use App\Form\HuntCatType;

use App\Repository\ImageRepository;
use App\Repository\HuntRepository;
use App\Repository\ImageCatRepository;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\HuntCatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_ADMIN_HUNTS")
* @Route("/admin/hunt")
*/
class HuntController extends AbstractController
{
    /**
     * @Route("/", name="admin_hunt_list")
     */
    public function list(HuntRepository $h)
    {
        return $this->render('back/hunt/list.html.twig', [
            'hunts' => $h->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_hunt_new")
     * @Route("/edit/{id}", name="admin_hunt_edit")
     */
    public function AddEdit(Hunt $h = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$h) {
            $h = new Hunt();
        }

        $form = $this->createForm(HuntType::class, $h);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $security->getUser();

            if(!$h->getImageBackground()){
                $h->setImageBackground(null);
            }
            if(!$h->getImageHead()){
                $h->setImageHead(null);
            }

            $h->setUser($user);
            $manager->persist($h);
            $manager->flush();
            return $this->redirectToRoute('admin_hunt_list');
        }

        return $this->render('back/hunt/addEdit.html.twig', [
            'form' => $form->createView(),
            'editMode'  => $h->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_hunt_delete")
     */
    public function delete(Hunt $h,ImageRepository $i, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){

            $imageBack = $i->findOneBy(['id' => $h->getImageBack()]);
            if ($imageBack) {
                $pathBack = 'uploads/images/'.$imageBack->getName();
            }

            $imageHead = $i->findOneBy(['id' => $h->getImageHead()]);
            if ($imageHead) {
                $pathHead = 'uploads/images/'.$imageHead->getName();
            }
            
            if ($imageBack && file_exists($pathBack)){
                $h->setImageBack(null);
                $manager->remove($imageBack);
                $manager->persist($h);
                $manager->flush();
                unlink($pathBack);
            }
            if ($imageHead && file_exists($pathHead)){
                $h->setImageHead(null);
                $manager->remove($imageHead);
                $manager->persist($h);
                $manager->flush();
                unlink($pathHead);
            }

            $manager->remove($h);
            $manager->flush();

            return $this->redirectToRoute('admin_hunt_list');
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/image/add/{id}", name="admin_hunt_new_image")
     */
    public function AddImage(Hunt $h, ImageCatRepository $iCat, Request $req, EntityManagerInterface $manager, Security $security)
    {
        $i = new Image();

        $formImg = $this->createForm(ImageType::class, $i);
        $formImg->handleRequest($req);

        if ($formImg->isSubmitted() && $formImg->isValid()){

            /** @var UploadedFile $brochureFile */
            $brochureFile = $formImg['name']->getData();

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
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents

            $user = $security->getUser();

            $h->setImageBackground($i);
            $i->setUser($user);

            $i->setName($newFilename);

            if ($formImg['alt']->getData() == null){
                $i->setAlt('Aucune description de l\'image');
            }

            $manager->persist($i);
            $manager->persist($h);
            $manager->flush();
            return $this->redirectToRoute('admin_hunt_list');
        }

        return $this->render('back/image/imageAddEdit.html.twig', [
            'formImage' => $formImg->createView(),
            'editMode'  => $h->getId() !== null
        ]);
    }

    /**
     * @Route("/image/delete/{id}", name="admin_hunt_delete_image")
     */
    public function deleteImage(Hunt $h, ImageRepository $i, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $image = $i->findOneBy(['id' => $h->getImageBackground()]);

            $path = 'uploads/images/'.$image->getName();

            if ($image && file_exists($path)){
                $h->setImageBackground(null);
                unlink($path);
                $manager->remove($image);
                $manager->persist($h);
                $manager->flush();
                return $this->redirectToRoute('admin_hunt_list');
            }
        }
    }

    /**
     * @Route("/imageHead/add/{id}", name="admin_hunt_new_imageHead")
     */
    public function AddImageHead(Hunt $h, ImageCatRepository $iCat, Request $req, EntityManagerInterface $manager, Security $security)
    {
        $i = new Image();

        $formImg = $this->createForm(ImageType::class, $i);
        $formImg->handleRequest($req);

        if ($formImg->isSubmitted() && $formImg->isValid()){

            /** @var UploadedFile $brochureFile */
            $brochureFile = $formImg['name']->getData();

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
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents

            $i->setUser($security->getUser());

            $i->setName($newFilename);

            if ($formImg['alt']->getData() == null){
                $i->setAlt('Aucune information sur l\'image est disponible');
            }

            $manager->persist($i);
            $h->setImageHead($i);
            $manager->persist($h);
            $manager->flush();
            return $this->redirectToRoute('admin_hunt_list');
        }

        return $this->render('back/image/imageAddEdit.html.twig', [
            'formImage' => $formImg->createView(),
            'editMode'  => $h->getId() !== null
        ]);
    }

    /**
     * @Route("/imageHead/delete/{id}", name="admin_hunt_delete_imageHead")
     */
    public function deleteImageHead(Hunt $h, ImageRepository $i, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $image = $i->findOneBy(['id' => $h->getImageHead()]);

            $path = 'uploads/images/'.$image->getName();

            if ($image && file_exists($path)){
                unlink($path);
                $h->setImageHead(null);
                $manager->remove($image);
                $manager->flush();
                return $this->redirectToRoute('admin_hunt_list');
            }
        }
    }

}