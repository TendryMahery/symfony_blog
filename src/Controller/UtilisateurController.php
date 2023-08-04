<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, ManagerRegistry $manager,UserPasswordEncoderInterface $encode ): Response
    {
        $utilisateur = new Utilisateur();
        $entityManager = $manager->getManager();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $mdp = $encode->encodePassword($utilisateur, $utilisateur->getMdp());
            $utilisateur->setMdp($mdp);
            $entityManager->persist($utilisateur);
            $entityManager->flush();
        }
        return $this->render('utilisateur/inscription.html.twig', [
            'controller_name' => 'UtilisateurController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(): Response
    {
        return $this->render('utilisateur/connexion.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

     /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(): Response
    {
       
    }
}
