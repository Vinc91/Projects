<?php

namespace PW\ProgresSiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Saison
 *
 * @ORM\Table(name="pw_saison")
 * @ORM\Entity(repositoryClass="PW\ProgresSiesBundle\Repository\SaisonRepository")
 */
class Saison
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
     * @ORM\ManyToOne(targetEntity="PW\ProgresSiesBundle\Entity\Serie", cascade={"persist"}, inversedBy="saisons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serie;

    /**
     * @ORM\OnetoMany(targetEntity="PW\ProgresSiesBundle\Entity\Episode", mappedBy="saison")
     * @ORM\JoinColumn(nullable=false)
     */
    private $episodes;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="num", type="integer")
     * @Assert\Range(min="1", minMessage="Choisissez un nombre supérieur à 0")
     */
    private $num;

    /**
     * @ORM\Column(name="nb_episodes", type="integer")
     * @Assert\Range(min="0", minMessage="Choisissez un nombre positif")
     */
    private $nbEpisodes;


    /**
     * @var bool
     *
     * @ORM\Column(name="checked", type="boolean")
     */
    private $checked=false;

    /**
     * @var float
     *
     * @ORM\Column(name="avancement", type="decimal")
     */
    private $avancement;

    public function __construct(){
        $this->avancement=0;
        $this->nbEpisodes=0;
        $this->episodes= new ArrayCollection();
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
     * @return Saison
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
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
     * Set checked
     *
     * @param boolean $checked
     *
     * @return Saison
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;
        if(true == $this->checked){
            $this->avancement=100;
        }else{
            if(false == $this->checked) {
                $this->avancement=0;
            }
        }
    }

    /**
     * Get checked
     *
     * @return bool
     */
    public function getChecked()
    {
        return $this->checked;
    }

    /**
     * Set serie
     *
     * @param \PW\ProgresSiesBundle\Entity\Serie $serie
     *
     * @return Saison
     */
    public function setSerie(\PW\ProgresSiesBundle\Entity\Serie $serie)
    {
        $this->serie = $serie;
    }

    /**
     * Get serie
     *
     * @return \PW\ProgresSiesBundle\Entity\Serie
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set avancement
     *
     * @param string $avancement
     *
     * @return Saison
     */
    public function setAvancement($avancement)
    {
        $this->avancement = $avancement;
    }

    /**
     * Get avancement
     *
     * @return string
     */
    public function getAvancement()
    {
        return $this->avancement;
    }

    /**
     * Set num
     *
     * @param integer $num
     *
     * @return Saison
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return integer
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Add episode
     *
     * @param \PW\ProgresSiesBundle\Entity\Episode $episode
     *
     * @return Saison
     */
    public function addEpisode(\PW\ProgresSiesBundle\Entity\Episode $episode)
    {
        $this->episodes[] = $episode;
        $episode->setSaison($this);
        return $this;
    }

    /**
     * Remove episode
     *
     * @param \PW\ProgresSiesBundle\Entity\Episode $episode
     */
    public function removeEpisode(\PW\ProgresSiesBundle\Entity\Episode $episode)
    {
        $this->episodes->removeElement($episode);
    }

    /**
     * Get episodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }

    public function searchNum($episodes) {

        $num = 1;
        foreach($episodes as $episode) {
            if($episode->getNum() != $num) {
                return $num;
            }else{
                $num=$num+1;
            }
        }
        return $num;
    }

    /**
     * Set nbEpisodes
     *
     * @param integer $nbEpisodes
     *
     * @return Saison
     */
    public function setNbEpisodes($nbEpisodes)
    {
        $this->nbEpisodes = $nbEpisodes;

        return $this;
    }

    /**
     * Get nbEpisodes
     *
     * @return integer
     */
    public function getNbEpisodes()
    {
        return $this->nbEpisodes;
    }

    public function setAvancementTotal() {
        $episodes = $this->getEpisodes();
        $avanctotale=0;
        foreach($episodes as $episodes) {
            if($episodes->getChecked() == true) {
                $avanctotale = $avanctotale + 100;
            }
        }
        if($this->nbEpisodes >0) {
        $avanctotale = $avanctotale / $this->nbEpisodes;
        }else{
            $avanctotale=0;
        }

        $this->setAvancement(round($avanctotale));
    }
}
