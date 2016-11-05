<?php

namespace PW\ProgresSiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Serie
 *
 * @ORM\Table(name="pw_serie")
 * @ORM\Entity(repositoryClass="PW\ProgresSiesBundle\Repository\SerieRepository")
 * @UniqueEntity(fields="titre", message="Une serie existe déjà avec ce titre.")
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
     * @ORM\ManyToMany(targetEntity="PW\ProgresSiesBundle\Entity\Genre", cascade={"persist"})
     * @ORM\JoinTable(name="pw_serie_genre")
     */
    private $genres;

    /**
     * @ORM\OneToMany(targetEntity="PW\ProgresSiesBundle\Entity\Saison", mappedBy="serie")
     */
  private $saisons;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, unique=true)
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
     * @Assert\Range(min="0", minMessage="Choisissez un nombre positif")
     */
    private $nbSaisons;

    /**
     * @var float
     *
     * @ORM\Column(name="avancement", type="decimal", nullable=true)
     */
    private $avancement;

    public function __construct(){

        $this->avancement = 0;
        $this->date= 2016;
        $this->genres = new ArrayCollection();
        $this->saisons = new ArrayCollection();
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

    /**
     * Add genre
     *
     * @param \PW\ProgresSies\Entity\Genre $genre
     *
     * @return Serie
     */
    public function addGenre(\PW\ProgresSiesBundle\Entity\Genre $genre)
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param \PW\ProgresSies\Entity\Genre $genre
     */
    public function removeGenre(\PW\ProgresSiesBundle\Entity\Genre $genre)
    {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Add saison
     *
     * @param \PW\ProgresSiesBundle\Entity\Saison $saison
     *
     * @return Serie
     */
    public function addSaison(\PW\ProgresSiesBundle\Entity\Saison $saison)
    {

        $this->saisons[] = $saison;
        $saison->setSerie($this);
        return $this;
    }

    /**
     * Remove saison
     *
     * @param \PW\ProgresSiesBundle\Entity\Saison $saison
     */
    public function removeSaison(\PW\ProgresSiesBundle\Entity\Saison $saison)
    {
        $this->saisons->removeElement($saison);
    }

    /**
     * Get saisons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSaisons()
    {
        return $this->saisons;
    }

    public function setAvancementTotal() {
        $saisons = $this->getSaisons();
        $avanctotale=0;
        foreach($saisons as $saison) {
            $avanctotale = $avanctotale + $saison->getAvancement();
        }
        if($this->nbSaisons >0) {
        $avanctotale = $avanctotale / $this->nbSaisons;
        }else{
            $avanctotale=0;
        }

        $this->setAvancement(round($avanctotale));
    }

    public function searchNum($saisons) {

        $num = 1;
        foreach($saisons as $saison) {
            if($saison->getNum() != $num) {
                return $num;
            }else{
                $num=$num+1;
            }
        }
        return $num;
    }
}
