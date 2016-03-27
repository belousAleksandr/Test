<?php
namespace ShopBundle\Admin;
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 26.06.15
 * Time: 20:57
 */

use Application\Sonata\MediaBundle\Form\GalleryType;
use ShopBundle\Entity\Product;
use Sonata\AdminBundle\Admin\Admin;

class ProductAdmin extends Admin{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $formMapper)
    {
        $formMapper
            ->with('Main')
            ->add('category')
            ->add('price')
            ->add('slug')
            ->add('title')
            ->add('name')
            ->add('mKeywords')
            ->add('mDescription')
            ->add('description', null, array('attr'=> array('class' => 'ckeditor')))
            ->add('gallery', new GalleryType(), array('label' => false))
            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(\Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper)
    {

    }

    // Fields to be shown on lists
    protected function configureListFields(\Sonata\AdminBundle\Datagrid\ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('price')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }
}