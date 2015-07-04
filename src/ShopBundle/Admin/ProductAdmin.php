<?php
namespace ShopBundle\Admin;
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 26.06.15
 * Time: 20:57
 */

use Sonata\AdminBundle\Admin\Admin;

class ProductAdmin extends Admin{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('description');
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(\Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper)
    {
    }

    // Fields to be shown on lists
    protected function configureListFields(\Sonata\AdminBundle\Datagrid\ListMapper $listMapper)
    {
    }
}