<?php

namespace Grossum\StaticPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class StaticPage
{
    const POSITION_DEFAULT = 1;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $body;

    /**
     * @var boolean
     */
    private $enabled;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Collection|StaticPage[]
     */
    private $children;

    /**
     * @var StaticPage
     */
    private $parent;

    public function __construct()
    {
        $this->children = new ArrayCollection();

        $this->position = static::POSITION_DEFAULT;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param boolean $enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param integer $position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param StaticPage $child
     *
     * @return $this
     */
    public function addChild(StaticPage $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * @param StaticPage $child
     */
    public function removeChild(StaticPage $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * @return Collection|StaticPage[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param StaticPage $parent
     *
     * @return $this
     */
    public function setParent(StaticPage $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return StaticPage
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ?: "Static page";
    }
}
