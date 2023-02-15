<?php

namespace App\Controller;

use Doctrine\Migrations\Configuration\EntityManager\ManagerRegistryEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArticleType;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @Route("/edit/{id}", name="edit")
     */
    public function index(Article $article = null,Request $request, ManagerRegistry $manager,ArticleRepository $repo): Response
    {
        if (!$article){
            $article = new Article();
        }
        $entityManager = $manager->getManager();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTimeImmutable());
            }
                $entityManager->persist($article);
                $entityManager->flush();
                return $this->redirectToRoute('admin');
        }
        $art = $repo->findAll();
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
            'article' => $art
        ]);
    }


}
