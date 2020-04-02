<?php

namespace App\Controller\Back\Image_controller;

use App\Entity\Image;
use App\Entity\ImageCat;

use App\Form\ImageArticleType;

use App\Repository\ImageRepository;
use App\Repository\ImageCatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_ADMIN_IMAGES_ARTICLE")
* @Route("/admin/image-article")
*/
class ImageArticleController extends AbstractController
{
    /**
     * @Route("/", name="admin_image_article_list")
     */
    public function listImage(ImageRepository $i)
    {
        return $this->render('back/image/imageArticleList.html.twig', [
            'images' => $i->findBy(['category' => 2])
        ]);
    }

    /**
     * @Route("/new", name="admin_image_article_new")
     */
    public function AddEditImage(ImageCatRepository $catRepo, Request $req, EntityManagerInterface $manager, Security $security)
    {
        $i = new Image();

        $form = $this->createForm(ImageArticleType::class, $i);
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

            $i->setUser($security->getUser());

            $i->setName($newFilename);

            if ($form['alt']->getData() == null){
                $i->setAlt('Aucune information sur l\'image est disponible');
            }

            $cat = $catRepo->findOneBy(['name' => 'article']);

            $i->setImageCat($cat);

            $manager->persist($i);
            $manager->flush();
            return $this->redirectToRoute('admin_image_article_list');
        }

        return $this->render('back/image/imageArticleAddEdit.html.twig', [
            'formImage' => $form->createView(),
            'editMode'  => $i->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_image_article_delete")
     */
    public function deleteImage(Image $i,ImageCatRepository $cat, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            if ($i) {
                unlink('uploads/images/'.$i->getName());
                $manager->remove($i);
                $manager->flush();
            }
            return $this->redirectToRoute('admin_image_article_list');
        }
    }

    /**
     * @Route("/tinymce/add")
     */
    public function tiny(ImageCatRepository $catRepo, Request $req, EntityManagerInterface $manager, Security $security) : Response
    {
        $i = new Image();

        $form = $this->createForm(ImageArticleType::class, $i);
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
                        $this->getParameter('image_folder' . '/article'),
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
                $i->setAlt('Aucune information sur l\'image est disponible');
            }

            $cat = $catRepo->findOneBy(['name' => 'article']);

            $test = $i->setImageCat($cat);

            $manager->persist($i);
            $manager->flush();
            return $this->redirectToRoute('admin_image_article_list');
        }

        return $this->render('back/image/imageArticleAddEdit.html.twig', [
            'formImage' => $form->createView(),
            'editMode'  => $i->getId() !== null
        ]);
    }
}