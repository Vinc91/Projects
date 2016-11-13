<?php

namespace PW\ProgresSiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Episode
 *
 * @ORM\Table(name="pw_episode")
 * @ORM\Entity(repositoryClass="PW\ProgresSiesBundle\Repository\EpisodeRepository")
 */
class Episode
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
     * @ORM\ManyToOne(targetEntity="PW\ProgresSiesBundle\Entity\Saison",cascade={"persist"}, inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $saison;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(name="num", type="integer")
     * @Assert\Range(min="1", minMessage="Choisissez un nombre supérieur à 0")
     */
    private $num;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="checked", type="boolean")
     */
    private $checked= false;


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
     * @return Episode
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
     * @return Episode
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;

        return $this;
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
     * Set saison
     *
     * @param \PW\ProgresSiesBundle\Entity\Saison $saison
     *
     * @return Episode
     */
    public function setSaison(\PW\ProgresSiesBundle\Entity\Saison $saison)
    {
        $this->saison = $saison;
    }

    /**
     * Get saison
     *
     * @return \PW\ProgresSiesBundle\Entity\Saison
     */
    public function getSaison()
    {
        return $this->saison;
    }

    /**
     * Set num
     *
     * @param integer $num
     *
     * @return Episode
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
}
