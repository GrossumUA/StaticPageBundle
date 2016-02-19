<?php

namespace Grossum\StaticPageBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

abstract class BaseStaticPage
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var boolean
     */
    protected $enabled;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var Collection|BaseStaticPage[]
     */
    protected $children;

    /**
     * @var BaseStaticPage
     */
    protected $parent;

    /**
     * @var BaseStaticPage
     */
    protected $root;

    /**
     * @var integer
     */
    protected $lft;

    /**
     * @var integer
     */
    protected $rgt;

    /**
     * @var integer
     */
    protected $lvl;

    /**
     * @var integer
     */
    protected $position;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->enabled  = true;
    }

    /**
     * @return integer
     */
    abstract public function getId();

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
     * @param BaseStaticPage $child
     *
     * @return $this
     */
    public function addChild(BaseStaticPage $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * @param BaseStaticPage $child
     */
    public function removeChild(BaseStaticPage $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * @return Collection|BaseStaticPage[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param BaseStaticPage $parent
     *
     * @return $this
     */
    public function setParent(BaseStaticPage $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return BaseStaticPage
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param integer $lft
     *
     * @return $this
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * @param integer $rgt
     *
     * @return $this
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * @param integer $lvl
     *
     * @return $this
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * @param BaseStaticPage $root
     *
     * @return $this
     */
    public function setRoot(BaseStaticPage $root = null)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * @return BaseStaticPage
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ?: "Static page";
    }
}
