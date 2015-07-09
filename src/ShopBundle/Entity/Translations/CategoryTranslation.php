<?php
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 05.07.15
 * Time: 10:01
 */

namespace ShopBundle\Entity\Translations;


use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * Entity\Translation\CategoryTranslation.php

 * @ORM\Entity
 * @ORM\Table(name="category_translations",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *     "locale", "object_id", "field"
 *   })}
 * )
 */
class CategoryTranslation extends AbstractPersonalTranslation {

    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Category", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}