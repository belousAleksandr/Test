<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Category;
use ShopBundle\Entity\CategoryRepository;
//use ShopBundle\Entity\Product;
use ShopBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CategoryRepository $categoriesRepository */
        $categoriesRepository = $em->getRepository('ShopBundle:Category');
        $categories = $categoriesRepository->findAllEnabled();

        return $this->render(':Frontend:index.html.twig', array('categories' => $categories));
    }

    public function productAction(Product $product)
    {

        return $this->render(':Frontend:product.html.twig', array('product' => $product));
    }

    public function categoryAction(Category $category)
    {
        return $this->render(':Frontend:category.html.twig', array('category' => $category));
    }

    public function categoriesAction()
    {
        /** @var CategoryRepository $categoryRepository */
        $categoryRepository = $this->getDoctrine()->getRepository(Category::REPOSITORY);
        $categories = $categoryRepository->findAllEnabled();

        return $this->render(':Frontend:categories.html.twig', array('categories' => $categories));
    }

    public function aboutUsAction()
    {
        return $this->render(':Frontend:aboutUs.html.twig', array());
    }
    public function contactUsAction() {
        return $this->render(':Frontend:contactUs.html.twig', array());
    }
}
