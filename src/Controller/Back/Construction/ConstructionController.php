<?php

namespace App\Controller\Back\Construction;

use App\Entity\Image;
use App\Form\ImageType;

use App\Entity\Construction;

use App\Form\ConstructionType;
use App\Entity\ConstructionCat;

use App\Form\ConstructionCatType;
use App\Repository\ImageRepository;
use App\Repository\ImageCatRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ConstructionRepository;
use App\Repository\ConstructionCatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_ADMIN_CONSTRUCTIONS")
* @Route("/admin/construction")
*/
class ConstructionController extends AbstractController
{
    /**
     * @Route("/", name="admin_construction_list")
     */
    public function list(ConstructionRepository $c)
    {
        return $this->render('back/construction/list.html.twig', [
            'constructions' => $c->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_construction_new")
     * @Route("/edit/{id}", name="admin_construction_edit")
     */
    public function AddEdit(Construction $c = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$c) {
            $c = new Construction();
        }

        $form = $this->createForm(ConstructionType::class, $c);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $security->getUser();

            if(!$c->getImage()){
                $c->setImage(null);
            }

            $c->setUser($user);
            $manager->persist($c);
            $manager->flush();
            return $this->redirectToRoute('admin_construction_list');
        }

        return $this->render('back/construction/addEdit.html.twig', [
            'form' => $form->createView(),
            'editMode'  => $c->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_construction_delete")
     */
    public function delete(Construction $c, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $manager->remove($c);
            $manager->flush();

            return $this->redirectToRoute('admin_construction_list');
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/image/add/{id}", name="admin_construction_new_image")
     */
    public function AddImage(Construction $c, ImageCatRepository $iCat, Request $req, EntityManagerInterface $manager, Security $security)
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

            $c->setImage($i);
            $i->setUser($user);

            $i->setName($newFilename);

            if ($formImg['alt']->getData() == null){
                $i->setAlt('Aucune information sur l\'image est disponible');
            }

            $i->setImageCat($iCat->findOneBy(['name' => 'construction']));

            $manager->persist($c);
            $manager->persist($i);
            $manager->flush();
            return $this->redirectToRoute('admin_construction_list');
        }

        return $this->render('back/construction/AddEditImage.html.twig', [
            'formImg' => $formImg->createView(),
            'editMode'  => $c->getId() !== null
        ]);
    }

    /**
     * @Route("/image/delete/{id}", name="admin_construction_delete_image")
     */
    public function deleteImage(Construction $c, ImageRepository $i, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $image = $i->findOneBy(['id' => $c->getImage()]);

            $path = 'uploads/images/'.$image->getName();

            if ($image && file_exists($path)){
                unlink($path);
                $c->setImage(null);
                $manager->remove($image);
                $manager->flush();
                return $this->redirectToRoute('admin_construction_list');
            }
        }
    }
}
