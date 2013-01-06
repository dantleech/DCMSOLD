<?php

namespace DCMS\Bundle\CoreBundle\Document;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use DCMS\Bundle\CoreBundle\Validation\Constraints as RoutingValidation;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Route;

/**
 * @PHPCR\Document(
 *  nodeType="dcms:endpoint",
 *  referenceable=true,
 *  repositoryClass="DCMS\Bundle\CoreBundle\Repository\EndpointRepository"
 * )
 */
class Endpoint
{
    /** 
     * @PHPCR\Id()
     */
    protected $id;

    /**
     * @PHPCR\Uuid()
     */
    protected $uuid;

    /** 
     * @PHPCR\ParentDocument()
     */
    protected $parent;

    /**
     * @PHPCR\Children()
     */
    protected $children;

    /** 
     * @PHPCR\NodeName()
     */
    protected $name;

    /**
     * Title (infer name from this if autoRoute)
     * @PHPCR\String()
     */
    protected $title;

    /**
     * If the children should be orderable
     *   - e.g. blog posts are non user-orderable
     *
     * @PHPCR\Boolean()
     */
    protected $orderableChildren = true;

    /**
     * @PHPCR\ReferenceOne(strategy="hard", targetDocument="DCMS\Bundle\ThemeBundle\Document\Template")
     */
    protected $layout;

    /**
     * @PHPCR\String()
     */
    protected $epClass;

    /**
     * @PHPCR\String(multivalue=true)
     */
    protected $parameters;

    /**
     * @PHPCR\Boolean()
     */
    protected $showInMenu = true;

    /**
     * @PHPCR\Boolean()
     */
    protected $autoName = true;

    /**
     * @PHPCR\Boolean()
     */
    protected $routeable = true;

    /**
     * @PHPCR\Node()
     */
    protected $node;

    public function __toString()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getEndpointParent()
    {
        if ($this->parent instanceOf Endpoint) {
            return $this->parent;
        }

        return null;
    }

    public function getChildren()
    {
        $children = array();
        foreach ($this->children as $child) {
            if ($child instanceOf Endpoint) {
                $children[] = $child;
            }
        }
        return $children;
    }
    
    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function addChild($child)
    {
        if (null === $this->children) {
            $this->children = new ArrayCollection();
        }
        $this->children->add($child);
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getEpClass()
    {
        return $this->epClass;
    }
    
    public function setEpClass($epClass)
    {
        $this->epClass = $epClass;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
    
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getUuid()
    {
        return $this->uuid;
    }
    
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function getLayout()
    {
        return $this->layout;
    }
    
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function getNode()
    {
        return $this->node;
    }

    public function getShowInMenu()
    {
        return $this->showInMenu;
    }
    
    public function setShowInMenu($showInMenu)
    {
        $this->showInMenu = $showInMenu;
    }

    public function getRouteInheritPath()
    {
        return $this->routeInheritPath;
    }
    
    public function setRouteInheritPath($routeInheritPath)
    {
        $this->routeInheritPath = $routeInheritPath;
    }

    public function getRouteable()
    {
        return $this->routeable;
    }
    
    public function setRouteable($routeable)
    {
        $this->routeable = $routeable;
    }

    public function getOrderableChildren()
    {
        return $this->orderableChildren;
    }
    
    public function setOrderableChildren($orderableChildren)
    {
        $this->orderableChildren = $orderableChildren;
    }

    public function getAutoName()
    {
        return $this->autoName;
    }
    
    public function setAutoName($autoName)
    {
        $this->autoName = $autoName;
    }

    /**
     * @PHPCR\PreUpdate()
     * @PHPCR\PrePersist()
     */
    public function prePersist()
    {
        $path = array();
        if (true === $this->autoName) {
            if (!$this->title) {
                throw new \Exception('Endpoint has autoName set, but title is empty. Use setTitle');
            }
            $this->name = $this->slugify($this->title);
        }
    }

    protected function slugify($name)
    {
        setlocale(LC_CTYPE, 'fr_FR.UTF8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $clean = strip_tags($clean);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        if (substr($clean, -1) == '-') {
            $clean = substr($clean, 0, -1);
        }

        return $clean;
    }
}
