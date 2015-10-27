<?php
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 26.10.15
 * Time: 20:07
 */

namespace ShopBundle\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;
/**
 * Entity\Translation\ProductCharacteristicTranslation.php

 * @ORM\Entity
 * @ORM\Table(name="product_characteristic_translations",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *     "locale", "object_id", "field"
 *   })}
 * )
 */

class ProductCharacteristicTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\ProductCharacteristic", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}