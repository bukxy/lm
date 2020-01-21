<?php

namespace App\Controller\Back\Research;

use App\Entity\Image;
use App\Form\ImageType;

use App\Entity\Research;
use App\Form\ResearchType;

use App\Entity\ResearchCat;
use App\Form\ResearchCatType;

use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ResearchRepository;
use App\Repository\ResearchCatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_ADMIN_RESEARCHS")
* @Route("/admin/research")
*/
class ResearchController extends AbstractController
{
    /**
     * @Route("/", name="admin_research_list")
     */
    public function list(ResearchRepository $r)
    {
        return $this->render('back/research/list.html.twig', [
            'researches' => $r->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_research_new")
     * @Route("/edit/{id}", name="admin_research_edit")
     */
    public function AddEdit(Research $r = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$r) {
            $r = new Research();
        }

        $form = $this->createForm(ResearchType::class, $r);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $security->getUser();

            if(!$r->getImage()){
                $r->setImage(null);
            }

            $r->setUser($user);
            $manager->persist($r);
            $manager->flush();
            return $this->redirectToRoute('admin_research_list');
        }

        return $this->render('back/research/addEdit.html.twig', [
            'form' => $form->createView(),
            'editMode'  => $r->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_research_delete")
     */
    public function delete(Research $r, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $manager->remove($r);
            $manager->flush();

            return $this->redirectToRoute('admin_research_list');
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/image/add/{id}", name="admin_research_new_image")
     */
    public function AddImage(Research $r, Image $i = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$i) {
            $i = new Image();
        }

        $formImg = $this->createForm(ImageType::class, $r);
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

            $r->setImage($i);
            $i->setUser($user);

            $i->setName($newFilename);

            if ($formImg['alt']->getData() == null){
                $i->setAlt('Aucune information sur l\'image est disponible');
            }

            $manager->persist($r);
            $manager->persist($i);
            $manager->flush();
            return $this->redirectToRoute('admin_research_list');
        }

        return $this->render('back/research/AddEditImage.html.twig', [
            'formImg' => $formImg->createView(),
            'editMode'  => $r->getId() !== null
        ]);
    }

    /**
     * @Route("/image/delete/{id}", name="admin_research_delete_image")
     */
    public function deleteImage(Research $r, ImageRepository $i, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $image = $i->findOneBy(['id' => $r->getImage()]);

            $path = 'uploads/images/'.$image->getName();

            if ($image && file_exists($path)){
                unlink($path);
                $r->setImage(null);
                $manager->remove($image);
                $manager->flush();
                return $this->redirectToRoute('admin_research_list');
            }
        }
    }
}
