<?php

namespace UserBundle\Controller;

use AppBundle\Entity\Facture;
use AppBundle\Entity\Favoris;
use AppBundle\Entity\Commande;
use AppBundle\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    public function detailsProduitAction() {

        return $this->render('@User/Default/details-produit.html.twig');
    }

    public function ContactAction() {

        return $this->render('@User/Default/contact.html.twig');
    }

    public function afficherPanierAction() {
        
        $em=$this->getDoctrine()->getManager();

        $user = $this->getUser();
        $commandes = $em->getRepository('AppBundle:Commande')->findBy([
                'user' => $user
            ]);
    
        return $this->render('@User/Default/panier.html.twig',array(
            'commandes' => $commandes));
    }

    public function ajouterAuPanierAction($id) {

        $em=$this->getDoctrine()->getManager();
        $produit=$this->getDoctrine()->getRepository('AppBundle:Produit')
        ->findOneById($id);

        $user = $this->getUser();

        $commande=new Commande();
        $commande->setDate(new \DateTime());
       
        $form= $this->createForm(CommandeType::class,$commande);
        $form->handleRequest($request);

       
        if ($form->isSubmitted()&& $form->isValid()){

            $ProduitID = $form->get('produit')->getData();
           $quantite = $form->get('quantite')->getData();

            $commande->setUser($user)
                    ->setProduit($produit)
                    ->setQuantite($quantite);
            
            $em->persist($commande);
            $em->flush();

        return new JsonResponse(array('message' => 'Le produit est ajouté au panier. '), 200);
        }

        return $this->render('@User/Default/panier.html.twig');
    }

    public function supprimerDuPanierAction($id) 
    {
        return $this->render('@User/Default/panier.html.twig');
    }

    public function ajouterFavorisAction($id) {

            $em=$this->getDoctrine()->getManager();
            $user = $this->getUser();
    
            $produit=$this->getDoctrine()->getRepository('AppBundle:Produit')
            ->findOneById($id);
    
            if ($produit->isFavoreddByUser($user) == false) {
                $favoris= new Favoris();
                $favoris->setCreatedAt(new \DateTime());
            
                $favoris->setUser($user);
                $favoris->setProduit($produit);
                $em->persist($favoris);
                $em->flush();
    
                return new JsonResponse(array('message' => 'Produit ajouté au favoris.'), 200);
        }
        return new JsonResponse(array('message' => 'Erreur, veuillez reessayer plus tard svp.'), 200);
    }

    public function payerCommandesAction($id){

        $em= $this->getDoctrine()->getManager();
        
        $user = $this->getUser();

        $commandes = $em->getRepository('AppBundle:Commande')->findOneById($user->getId());
        $total = 0;
        
        $achat = [];

        foreach ($commandes as $commande ) {
            
            $total += $commande->getPrix();
            $info = $commande->getProduit()->getNom() .' : '. $commande->getQuantite();

            array_push($achat, $info);
        }

        $facture = new Facture();
        $facture->setUser($user)
                ->setTotal($total)
                ->setAchat($achat)
                ->setDate(new \DateTime());

        $em->persist($facture);
        $em->flush();

        $mail= \Swift_Message::newInstance()
            ->setSubject('Facture')
            ->setFrom('bmgidveytest@gmail.com')
            ->setTo($user->getEmail())
            ->setBody('test');

        $this->get('mailer')->send($mail);
         
        return $this->redirectToRoute('navigation_plan');
    }
   
    public function afficherFavorisAction() {

        $em=$this->getDoctrine()->getManager();
        $user = $this->getUser();
        $favoris=$em->getRepository('AppBundle:Favoris')->findBy([
                'user' => $user
            ]);
    
        return $this->render('@User/Default/favoris.html.twig',array(
            'favoris' => $favoris));
    }

    public function supprimerFavorisAction($id) {

        $em= $this->getDoctrine()->getManager();

        $favoris=$em->getRepository('AppBundle:Favoris')->findOneById($id);

            $em->remove($favoris);
            $em->flush();
            $this->addFlash(
                'error',
                'Favoris supprimé');
        
            return $this->redirectToRoute('afficher_favoris');
    }


    public function afficherCommentairesAction(Request $request)
    {
        $user = $this->getUser();

        $commentaire=$this->getDoctrine()->getRepository('AppBundle:Commentaire')->findBy([
            'user' => $user
        ]);
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $commentaire,
            $request->query->get('page',1),3);

        return $this->render('NavigationBundle:Default:commentaire.html.twig',array(
            'commentaire'=>$result ));
    }

    public function supprimerCommentaireAction($id){

        $em= $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('AppBundle:Commentaire')->find($id);

            $em->remove($commentaire);
            $em->flush();
            $this->addFlash(
                'error',
                'commentaire supprimé');

        return $this->redirectToRoute('commentaires_user');
    }
}
