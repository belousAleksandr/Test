<?php

namespace ShopBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="ShopBundle\Entity\Translations\ProductTranslation")
 * @ORM\HasLifecycleCallbacks()
 */
class Product extends AbstractPersonalTranslatable implements TranslatableInterface
{

    const REPOSITORY = 'ShopBundle:Product';
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string")
     */
    protected $slug;


    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Category", inversedBy="products")
     */
    protected $category;


    /**
     * @var string $title
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $name
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var string $description
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string $shortDescription
     *
     * @ORM\Column(name="m_description", type="string")
     * @Gedmo\Translatable
     */
    protected $mDescription;

    /**
     * @var string $shortDescription
     *
     * @ORM\Column(name="m_keywords", type="string")
     * @Gedmo\Translatable
     */
    protected $mKeywords;

    /**
     * @ORM\OneToMany(
     *     targetEntity="ShopBundle\Entity\Translations\ProductTranslation",
     *  mappedBy="object",
     *  cascade={"persist", "remove"}
     * )
     * @Assert\Valid(deep = true)
     */
    protected $translations;

    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", cascade={"persist", "remove"})
     */
    private $gallery;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * @return mixed
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param mixed $gallery
     * @return $this
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if (is_null($this->getGallery())) {
            $gallery = new Gallery();
            $gallery->setEnabled(true);
            $gallery->setName($this->getName());
            $gallery->setContext("default");
            $gallery->setDefaultFormat("default_big");
            $this->setGallery($gallery);
        }
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->getId()? $this->getTitle(): 'New product';
    }

    /**
     * Set category
     *
     * @param \ShopBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\ShopBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ShopBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }


    /**
     * Set mDescription
     *
     * @param string $mDescription
     * @return Product
     */
    public function setMDescription($mDescription)
    {
        $this->mDescription = $mDescription;

        return $this;
    }

    /**
     * Get mDescription
     *
     * @return string 
     */
    public function getMDescription()
    {
        return $this->mDescription;
    }

    /**
     * Set mKeywords
     *
     * @param string $mKeywords
     * @return Product
     */
    public function setMKeywords($mKeywords)
    {
        $this->mKeywords = $mKeywords;

        return $this;
    }

    /**
     * Get mKeywords
     *
     * @return string 
     */
    public function getMKeywords()
    {
        return $this->mKeywords;
    }
}
