<?php
namespace ShopBundle\Entity\Translations;
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 05.07.15
 * Time: 9:52
 */

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * Entity\Translation\PropertyTranslation.php

 * @ORM\Entity
 * @ORM\Table(name="property_translations",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *     "locale", "object_id", "field"
 *   })}
 * )
 */
class PropertyTranslation extends AbstractPersonalTranslation {

    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Property", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}