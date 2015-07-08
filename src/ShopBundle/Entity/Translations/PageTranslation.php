<?php
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 08.07.15
 * Time: 20:02
 */

namespace ShopBundle\Entity\Translations;


use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * Entity\Translation\PropertyTranslation.php

 * @ORM\Entity
 * @ORM\Table(name="page_translations",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *     "locale", "object_id", "field"
 *   })}
 * )
 */
class PageTranslation extends AbstractPersonalTranslation  {

    /**
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Page", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}