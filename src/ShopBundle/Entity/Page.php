<?php

namespace ShopBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Gallery;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="ShopBundle\Entity\Translations\PageTranslation")
 * @ORM\HasLifecycleCallbacks()
 */
class Page extends AbstractPersonalTranslatable implements TranslatableInterface
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
     * @var string $title
     *
     * @ORM\Column(name="page_key", type="string", length=100)
     */
    private $key;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Gedmo\Translatable
     */
    private $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="m_description", type="text")
     * @Gedmo\Translatable
     */
    private $mDescription;

    /**
     * @var string $shortDescription
     *
     * @ORM\Column(name="m_keywords", type="string")
     * @Gedmo\Translatable
     */
    protected $mKeywords;

    /**
     * @var string $description
     *
     * @ORM\Column(name="content", type="text")
     * @Gedmo\Translatable
     */
    private $content;

    /**
     * @ORM\OneToMany(
     *     targetEntity="ShopBundle\Entity\Translations\PageTranslation",
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
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
     * @return Page
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getMDescription()
    {
        return $this->mDescription;
    }

    /**
     * @param string $mDescription
     * @return Page
     */
    public function setMDescription($mDescription)
    {
        $this->mDescription = $mDescription;
        return $this;
    }


    public function __toString() {
        return $this->getId()? $this->getName(): 'New page';
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return Page
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }


    /**
     * Set mKeywords
     *
     * @param string $mKeywords
     * @return Page
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
     * @ORM\PreUpdate
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
}
