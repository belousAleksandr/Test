<?php
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 26.10.15
 * Time: 20:16
 */
namespace ShopBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
class ProductCharacteristicAdmin extends Admin
{
    /**
     * The base route name used to generate the routing information.
     *
     * @var string
     */
    protected $baseRouteName= 'admin_shop_product_characteristic';

    /**
     * The base route pattern used to generate the routing information.
     *
     * @var string
     */
    protected $baseRoutePattern;

// Fields to be shown on create/edit forms
    protected function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('value');
    }
}