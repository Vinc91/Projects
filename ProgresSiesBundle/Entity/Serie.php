<?php

namespace PW\ProgresSiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Serie
 *
 * @ORM\Table(name="pw_serie")
 * @ORM\Entity(repositoryClass="PW\ProgresSiesBundle\Repository\SerieRepository")
 */
class Serie
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
    * @ORM\OneToOne(targetEntity="PW\ProgresSiesBundle\Entity\Image", cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="integer", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="createur", type="string", length=255, nullable=true)
     */
    private $createur;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_saisons", type="integer")
     */
    private $nbSaisons;

    /**
     * @var float
     *
     * @ORM\Column(name="avancement", type="decimal")
     */
    private $avancement;

    public function __construct(){

        $this->avancement = 0;
        $this->date= 2016;
    }
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Serie
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Serie
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set createur
     *
     * @param string $createur
     *
     * @return Serie
     */
    public function setCreateur($createur)
    {
        $this->createur = $createur;
    }

    /**
     * Get createur
     *
     * @return string
     */
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * Set nbSaisons
     *
     * @param integer $nbSaisons
     *
     * @return Serie
     */
    public function setNbSaisons($nbSaisons)
    {
        $this->nbSaisons = $nbSaisons;
    }

    /**
     * Get nbSaisons
     *
     * @return int
     */
    public function getNbSaisons()
    {
        return $this->nbSaisons;
    }

    /**
     * Set avancement
     *
     * @param float $avancement
     *
     * @return Serie
     */
    public function setAvancement($avancement)
    {
        $this->avancement = $avancement;
    }

    /**
     * Get avancement
     *
     * @return float
     */
    public function getAvancement()
    {
        return $this->avancement;
    }

    /**
     * Set image
     *
     * @param \PW\ProgresSiesBundle\Entity\Image $image
     *
     * @return Serie
     */
    public function setImage(\PW\ProgresSiesBundle\Entity\Image $image = null)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return \PW\ProgresSiesBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
