<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\Column(name="nom", type="string", length=255, nullable=true)
    */
    protected $nom;

    /**
    * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
    */
    protected $prenom;


    /**
    * @ORM\Column(name="tel", type="integer", nullable=true)
     * @Assert\Length(
     *      min = 8,
     *      max = 9,
     *      minMessage = "Votre numéro de telephone ne doit contenir que 8 chiffres ",
     *      maxMessage = "Votre numéro de telephone ne doit contenir que 8 chiffres "
     * )
     */
    protected $tel;

}
