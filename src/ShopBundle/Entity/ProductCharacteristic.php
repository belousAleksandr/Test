<?php
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 26.10.15
 * Time: 20:04
 */

namespace ShopBundle\Entity;

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
 * @Gedmo\TranslationEntity(class="ShopBundle\Entity\Translations\ProductCharacteristicTranslation")
 */
class ProductCharacteristic extends AbstractPersonalTranslatable implements TranslatableInterface
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
     * @ORM\OneToMany(
     *     targetEntity="ShopBundle\Entity\Translations\ProductCharacteristicTranslation",
     *  mappedBy="object",
     *  cascade={"persist", "remove"}
     * )
     * @Assert\Valid(deep = true)
     */
    protected $translations;

    /**
     * @var string $name
     *
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Characteristic")
     */
    protected $name;

    /**
     * @var string $name
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="c_value", type="string", length=255)
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Product", inversedBy="characteristic")
     */
    protected $product;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Set product
     *
     * @param \ShopBundle\Entity\Product $product
     * @return ProductCharacteristic
     */
    public function setProduct(\ShopBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \ShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set name
     *
     * @param \ShopBundle\Entity\Characteristic $name
     * @return ProductCharacteristic
     */
    public function setName(\ShopBundle\Entity\Characteristic $name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return \ShopBundle\Entity\Characteristic 
     */
    public function getName()
    {
        return $this->name;
    }
}
