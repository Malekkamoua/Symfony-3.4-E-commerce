<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_produit", type="string", length=255)
     */
    private $nom_produit;

    /**
     * @ORM\OneToMany(targetEntity="Favoris",mappedBy="Produit" ,cascade={"persist", "remove"}))
     */
    private $favoris;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commentaire", mappedBy="Produit",orphanRemoval=true)
     */
    private $commentaire;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->favoris = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentaire = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add favori
     *
     * @param \AppBundle\Entity\Favoris $favori
     *
     * @return Produit
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
     * @return Produit
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

    /**
     * Set nomProduit
     *
     * @param string $nomProduit
     *
     * @return Produit
     */
    public function setNomProduit($nomProduit)
    {
        $this->nom_produit = $nomProduit;

        return $this;
    }

    /**
     * Get nomProduit
     *
     * @return string
     */
    public function getNomProduit()
    {
        return $this->nom_produit;
    }

    public function isFavoreddByUser(User $user){
        foreach ($this->favoris as $favoris) {
            if ($favoris->getUser() === $user) {
                return true;
            }
        }
        return false;
    }
}
