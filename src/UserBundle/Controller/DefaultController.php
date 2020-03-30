<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    public function detailsProduitAction()
    {
        return $this->render('@User/Default/details-produit.html.twig');
    }

    public function ContactAction()
    {
        return $this->render('@User/Default/contact.html.twig');
    }

    public function PanierAction()
    {
        return $this->render('@User/Default/panier.html.twig');
    }
}
