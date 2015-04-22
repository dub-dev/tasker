<?php

namespace TaskerBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="User")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Board", mappedBy="users")
     */
    protected $boards;


    /**
     * Get id
     *
     * @return integer
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
        parent::__construct();
        $this->boards = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add boards
     *
     * @param \TaskerBundle\Entity\Board $boards
     * @return User
     */
    public function addBoard(\TaskerBundle\Entity\Board $boards)
    {
        $this->boards[] = $boards;

        return $this;
    }

    /**
     * Remove boards
     *
     * @param \TaskerBundle\Entity\Board $boards
     */
    public function removeBoard(\TaskerBundle\Entity\Board $boards)
    {
        $this->boards->removeElement($boards);
    }

    /**
     * Get boards
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBoards()
    {
        return $this->boards;
    }
}
