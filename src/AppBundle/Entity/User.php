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

    /**
     * @ORM\OneToMany(targetEntity="Favoris", mappedBy="user" ,cascade={"persist", "remove"}))
     */
    private $favoris;

   /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commentaire", mappedBy="user",orphanRemoval=true)
     */
    private $commentaire;


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     *
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return integer
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Add favori
     *
     * @param \AppBundle\Entity\Favoris $favori
     *
     * @return User
     */
    public function addFavori(\AppBundle\Entity\Favoris $favori)
    {
        $this->favoris[] = $favori;

        return $this;
    }

    /**
     * Remove favori
     *
     * @param \AppBundle\Entity\Favoris $favori
     */
    public function removeFavori(\AppBundle\Entity\Favoris $favori)
    {
        $this->favoris->removeElement($favori);
    }

    /**
     * Get favoris
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavoris()
    {
        return $this->favoris;
    }

    /**
     * Add commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return User
     */
    public function addCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaire[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaire->removeElement($commentaire);
    }

    /**
     * Get commentaire
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}
