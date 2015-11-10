<?php
namespace ShopBundle\Admin;
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 26.06.15
 * Time: 20:57
 */

use ShopBundle\Entity\Product;
use ShopBundle\Entity\ProductCharacteristic;
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
            ->add('description')
            ->add('shortDescription')
            ->end()
            ->with('Characteristic')
            ->add('characteristic', 'sonata_type_collection',
                array('by_reference' => false),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))
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
            ->add('title')
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('gallery')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    public function preUpdate($object)
    {
        $this->setData($object);
    }

    protected function setData(Product $product){
        /** @var ProductCharacteristic $characteristic */
        foreach($product->getCharacteristic() as $characteristic){
            $characteristic->setProduct($product);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $this->setData($object);
    }
}