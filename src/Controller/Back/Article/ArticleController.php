<?php

namespace App\Controller\Back\Article;

use App\Entity\Article;
use App\Form\ArticleType;

use Cocur\Slugify\Slugify;
use App\Repository\ImageRepository;
use App\Repository\ResearchRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ResearchCatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_ADMIN_ARTICLES")
* @Route("/admin/article")
*/
class ArticleController extends AbstractController
{
    /**
     * @Route("/new", name="admin_article_new")
     * @Route("/edit/{slug}", name="admin_article_edit")
     */
    public function edit(Article $a = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$a) {
            $a = new Article();
        }

        $form = $this->createForm(ArticleType::class, $a);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            // $slugify = new Slugify();
            // $a->setSlug($slugify->slugify($form['title']->getData()));

            $a->setUser($security->getUser());

            $manager->persist($a);
            $manager->flush();
            return $this->redirectToRoute('admin_article_edit', ['slug' => $a->getSlug()]);
        }

        return $this->render('back/article/addEdit.html.twig', [
            'form' => $form->createView(),
            'editMode'  => $a->getId() !== null,
            'article' => $a
        ]);
    }
}
