<?php

namespace ShopBundle\Menu;

use Doctrine\ORM\EntityRepository;
use Knp\Menu\FactoryInterface;
use ShopBundle\Entity\Category;
use ShopBundle\Entity\Product;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home page', array('route' => 'shop_homepage'));

        // create another menu item
        $menu->addChild('About us', array('route' => 'shop_about_us'));
        $menu->addChild('Contuct us', array('route' => 'shop_contact_us'));

        return $menu;
    }

    public function categoryMenu(FactoryInterface $factory, array $options)
    {
        $request = $this->container->get('request');
        $attributes = $request->attributes;

        // access services from the container!
        $em = $this->container->get('doctrine')->getManager();

        /** @var EntityRepository $categoryRepository */
        $categoryRepository = $em->getRepository(Category::REPOSITORY);

        /** @var EntityRepository $productRepository */
        $productRepository = $em->getRepository(Product::REPOSITORY);


        /** @var Category $category */
        $category = $categoryRepository->findOneBy(array('slug' => $attributes->get('category_slug')));

        $menu = $factory->createItem('root');


        $menu->addChild($category->getName(), array(
            'route' => $attributes->get('slug')? 'shop_category': false,
            'routeParameters' => array('category_slug' => $category->getSlug())
        ));


        if($attributes->get('slug')) {
            /** @var Product $product */
            $product = $productRepository->findOneBy(array('slug' => $attributes->get('slug')));

            $menu->addChild($product->getName(), array('route' => false));
        }


        return $menu;
    }
}