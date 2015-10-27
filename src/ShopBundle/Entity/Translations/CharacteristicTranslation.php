<?php
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 27.10.15
 * Time: 19:49
 */

namespace ShopBundle\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * Entity\Translation\CharacteristicTranslation.php

 * @ORM\Entity
 * @ORM\Table(name="characteristic_translations",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *     "locale", "object_id", "field"
 *   })}
 * )
 */

class CharacteristicTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Characteristic", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;

}