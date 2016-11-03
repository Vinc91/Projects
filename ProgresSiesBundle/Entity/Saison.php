<?php

namespace PW\ProgresSiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

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
}
