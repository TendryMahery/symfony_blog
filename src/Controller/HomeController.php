<?php

namespace App\Controller;

use App\Repository\CommentaireRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\CommentaireType;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index( ArticleRepository $repository, Request $request,ManagerRegistry $manager): Response
    {
    
        $utilisateur = new Utilisateur();
        $commentaire = new Commentaire();
        $entityManager = $manager->getManager();
        $user = $this->getUser();
        #$article = $article->getId();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$user){
            //
            }else{
            $commentaire->setUtilisateur($user);
            $entityManager->persist($commentaire);
            $entityManager->flush();
            }
        }
        $article = $repository->findAll();
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("show/{id}", name="show")
     */
    public  function show(Article $article,CommentaireRepository $repoComms,ArticleRepository $repoArticle,
                          UtilisateurRepository $repoUser,Request $request,ManagerRegistry $manager){
        $article = $repoArticle->find($article);
        $entityManager = $manager->getManager();
        $comms = new Commentaire();
        $form = $this->createForm(CommentaireType::class,$comms );
        $user = $this->getUser();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if ($user){
                $comms->setUtilisateur($user);
                $comms->setArticle($article);
                $entityManager->persist($comms);
                $entityManager->flush();
            }else{
                $this->addFlash('error',"Vous n'êtes pas authentifier");
            }

        }
        return $this->render('home/show.html.twig', [
            'controller_name' => 'AdminController',
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}
