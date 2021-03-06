<?php

namespace App\Controller\Back\Familiar;

use App\Entity\Image;
use App\Entity\Familiar;
use App\Entity\FamiliarCat;

use App\Form\ImageType;
use App\Form\FamiliarType;
use App\Form\FamiliarCatType;

use App\Repository\ImageRepository;
use App\Repository\FamiliarRepository;
use App\Repository\ImageCatRepository;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FamiliarCatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_ADMIN_FAMILIARS")
* @Route("/admin/familiar")
*/
class FamiliarController extends AbstractController
{
    /**
     * @Route("/", name="admin_familiar_list")
     */
    public function list(FamiliarRepository $f)
    {
        return $this->render('back/familiar/list.html.twig', [
            'familiars' => $f->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_familiar_new")
     * @Route("/edit/{id}", name="admin_familiar_edit")
     */
    public function AddEdit(Familiar $f = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$f) {
            $f = new Familiar();
        }

        $form = $this->createForm(FamiliarType::class, $f);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $security->getUser();

            if(!$f->getImageBackground()){
                $f->setImageBackground(null);
            }
            if(!$f->getImageHead()){
                $f->setImageHead(null);
            }

            $f->setUser($user);
            $manager->persist($f);
            $manager->flush();
            return $this->redirectToRoute('admin_familiar_list');
        }

        return $this->render('back/familiar/addEdit.html.twig', [
            'form' => $form->createView(),
            'editMode'  => $f->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_familiar_delete")
     */
    public function delete(Familiar $f, ImageRepository $i, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){

            $imageBack = $i->findOneBy(['id' => $f->getImageBackground()]);
            if ($imageBack) {
                $pathBack = 'uploads/images/'.$imageBack->getName();
            }

            $imageHead = $i->findOneBy(['id' => $f->getImageHead()]);
            if ($imageHead) {
                $pathHead = 'uploads/images/'.$imageHead->getName();
            }
            
            if ($imageBack && file_exists($pathBack)){
                $f->setImageBackground(null);
                $manager->remove($imageBack);
                $manager->persist($f);
                $manager->flush();
                unlink($pathBack);
            }
            if ($imageHead && file_exists($pathHead)){
                $f->setImageHead(null);
                $manager->remove($imageHead);
                $manager->persist($f);
                $manager->flush();
                unlink($pathHead);
            }

            $manager->remove($f);
            $manager->flush();

            return $this->redirectToRoute('admin_familiar_list');
            // return $this->render('back/debug.html.twig', [
            //     'test'  =>  dump($imageBack, $imageHead)
            // ]);
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/background/add/{id}", name="admin_familiar_new_imageBackground")
     */
    public function AddImage(Familiar $f, ImageCatRepository $iCat, Request $req, EntityManagerInterface $manager, Security $security)
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

            $f->setImageBackground($i);
            $i->setUser($user);

            $i->setName($newFilename);

            if ($formImg['alt']->getData() == null){
                $i->setAlt('Aucune description de l\'image');
            }

            $manager->persist($i);
            $manager->persist($f);
            $manager->flush();
            return $this->redirectToRoute('admin_familiar_list');
        }

        return $this->render('back/image/imageAddEdit.html.twig', [
            'formImage' => $formImg->createView(),
            'editMode'  => $f->getId() !== null
        ]);
    }

    /**
     * @Route("/background/delete/{id}", name="admin_familiar_delete_imageBackground")
     */
    public function deleteImage(Familiar $f, ImageRepository $i, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $image = $i->findOneBy(['id' => $f->getImageBackground()]);

            $path = 'uploads/images/'.$image->getName();

            if ($image && file_exists($path)){
                $f->setImageBackground(null);
                unlink($path);
                $manager->remove($image);
                $manager->persist($image);
                $manager->persist($f);
                $manager->flush();
                return $this->redirectToRoute('admin_familiar_list');
            }
        }
    }

    /**
     * @Route("/imageHead/add/{id}", name="admin_familiar_new_imageHead")
     */
    public function AddImageHead(Familiar $f, ImageCatRepository $iCat, Request $req, EntityManagerInterface $manager, Security $security)
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
            $f->setImageHead($i);
            $manager->persist($f);
            $manager->flush();
            return $this->redirectToRoute('admin_familiar_list');
        }

        return $this->render('back/image/imageAddEdit.html.twig', [
            'formImage' => $formImg->createView(),
            'editMode'  => $f->getId() !== null
        ]);
    }

    /**
     * @Route("/imageHead/delete/{id}", name="admin_familiar_delete_imageHead")
     */
    public function deleteImageHead(Familiar $f, ImageRepository $i, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $image = $i->findOneBy(['id' => $f->getImageHead()]);

            $path = 'uploads/images/'.$image->getName();

            if ($image && file_exists($path)){
                unlink($path);
                $f->setImageHead(null);
                $manager->remove($image);
                $manager->flush();
                return $this->redirectToRoute('admin_familiar_list');
            }
        }
    }

}