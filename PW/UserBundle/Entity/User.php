<?php

namespace PW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Table(name="pw_user")
 * @ORM\Entity(repositoryClass="PW\UserBundle\Repository\UserRepository")
 */
class User extends BaseUSer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="PW\ProgresSiesBundle\Entity\Serie", mappedBy="user")
     */
    private $series;

    /**
     * Add series
     *
     * @param \PW\ProgresSiesBundle\Entity\Serie $series
     *
     * @return User
     */
    public function addSerie(\PW\ProgresSiesBundle\Entity\Serie $serie)
    {
        $this->series[] = $serie;
        $serie->setUser($this);
        return $this;
    }

    /**
     * Remove series
     *
     * @param \PW\ProgresSiesBundle\Entity\Serie $series
     */
    public function removeSerie(\PW\ProgresSiesBundle\Entity\Serie $serie)
    {
        $this->serie->removeElement($serie);
    }

    /**
     * Get series
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeries()
    {
        return $this->series;
    }
}
