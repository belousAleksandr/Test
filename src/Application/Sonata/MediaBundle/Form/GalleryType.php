<?php

namespace Application\Sonata\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 09.08.15
 * Time: 19:53
 */

class GalleryType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {


        $resolver->setDefaults(array(
            'data_class' => 'Application\Sonata\MediaBundle\Entity\Gallery',
            'mapped' => false
        ));
    }

    public function getParent()
    {
        return 'hidden';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "gallery";
    }
}