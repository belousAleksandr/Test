<?php

namespace ShopBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
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
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
     * @return mixed
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param mixed $gallery
     * @return Property
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


    public function __toString() {
        return $this->getId()? $this->getTitle(): 'New Category';
    }
}
