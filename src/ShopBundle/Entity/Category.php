<?php

namespace ShopBundle\Entity;


use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\MediaBundle\Model\GalleryHasMedia;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ShopBundle\Entity\CategoryRepository")
 * @Gedmo\TranslationEntity(class="ShopBundle\Entity\Translations\CategoryTranslation")
 * @ORM\HasLifecycleCallbacks()
 */
class Category extends AbstractPersonalTranslatable implements TranslatableInterface
{
    const REPOSITORY = 'ShopBundle\Entity\Category';
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $enabled
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled;

    /**
     * @var Product[]
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Product", mappedBy="category")
     */
    protected $products;


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
     * @var string $description
     *
     * @ORM\Column(name="slug", type="string")
     */
    protected $slug;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text")
     * @Gedmo\Translatable
     */
    protected $description;

    /**
     * @var string $shortDescription
     *
     * @ORM\Column(name="short_description", type="text")
     * @Gedmo\Translatable
     */
    protected $shortDescription;

    /**
     * @ORM\OneToMany(
     *     targetEntity="ShopBundle\Entity\Translations\CategoryTranslation",
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
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $locale
     * @return null|string
     */
    public function getShortDescription($locale = 'ru')
    {
        return $this->getTranslation('shortDescription', $locale );
    }

    /**
     * @param string $shortDescription
     * @return Category
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }



    /**
     * @return Gallery
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
            $gallery->setName($this->getTitle());
            $gallery->setContext("default");
            $gallery->setDefaultFormat("default_big");
            $this->setGallery($gallery);
        }
    }

    /**
     * @return null|\Sonata\MediaBundle\Model\MediaInterface
     */
    public function getFirstMedia() {
        $gallery = $this->getGallery();
        $galleryHasMedias = $gallery->getGalleryHasMedias();

        /** @var GalleryHasMedia $galleryHasMedia */
        $galleryHasMedia = $galleryHasMedias->first();
        if($galleryHasMedia) {
            return $galleryHasMedia->getMedia();
        }

        return null;
    }

    /**
     * @return string
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param string $enabled
     * @return Category
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }



    public function __toString() {
        return $this->getId()? $this->getTitle(): 'New Category';
    }

    /**
     * Add products
     *
     * @param \ShopBundle\Entity\Product $products
     * @return Category
     */
    public function addProduct(\ShopBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \ShopBundle\Entity\Product $products
     */
    public function removeProduct(\ShopBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
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
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
}
