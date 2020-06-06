<?php

namespace App\Controller\Back\Hunt;

use App\Entity\HuntCat;
use App\Form\HuntCatType;
use App\Repository\HuntCatRepository;

use App\Repository\HuntRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_ADMIN_HUNTS")
* @Route("/admin/hunt-category")
*/
class HuntCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_hunt_category_list")
     */
    public function list(HuntCatRepository $f)
    {
        return $this->render('back/hunt/catList.html.twig', [
            'categories' => $f->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_hunt_category_new")
     * @Route("/edit/{id}", name="admin_hunt_category_edit")
     */
    public function AddEditCategory(HuntCat $h = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$h) {
            $h = new HuntCat();
        }

        $form = $this->createForm(HuntCatType::class, $h);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $h->setUser($user);
            $manager->persist($h);
            $manager->flush();
            return $this->redirectToRoute('admin_hunt_category_list');
        }

        return $this->render('back/hunt/catAddEdit.html.twig', [
            'formCat' => $form->createView(),
            'editMode'  => $h->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_hunt_category_delete")
     */
    public function deleteCategory(HuntCat $h, HuntCatRepository $hCatRepo, HuntRepository $hRepo, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $hs = $hRepo->findBy(['huntCat' => $h->getId()]);
        
            if($hs){
                $cat = $hCatRepo->find(['id' => 1]);
                foreach ($hs as $hunt) {
                    $hunt->setHuntCat($cat);
                    $manager->persist($hunt);
                }
            }

            $manager->remove($h);
            $manager->flush();

            return $this->redirectToRoute('admin_hunt_category_list');
        }
    }
}
