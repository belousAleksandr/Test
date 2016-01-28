<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Category;
use ShopBundle\Entity\CategoryRepository;
//use ShopBundle\Entity\Product;
use ShopBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CategoryRepository $categoriesRepository */
        $categoriesRepository = $em->getRepository('ShopBundle:Category');
        $categories = $categoriesRepository->findAllEnabled();

        return $this->render(':Frontend:index.html.twig', array('categories' => $categories,
            'page' => $this->getPage('index')));
    }

    public function productAction(Product $product)
    {

        return $this->render(':Frontend:product.html.twig', array('page' => $product));
    }

    public function categoryAction(Request $request)
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::REPOSITORY);
        $category = $categoryRepository->findOneBy(array('slug' => $request->attributes->get('category_slug')));
        if(!$category) {
            throw new \Exception('Category is not found');
        }
        return $this->render(':Frontend:category.html.twig', array('page' => $category));
    }

    public function aboutUsAction()
    {
        return $this->render(':Frontend:aboutUs.html.twig', array('page' => $this->getPage('about_us')));
    }

    private function getPage($key) {
        $pageRepository = $this->getDoctrine()->getRepository('ShopBundle:Page');
        $page = $pageRepository->findOneBy(array('key' => $key));
        if(!$page) {
            throw new \Exception('Page is not found');
        }

        return $page;
    }
    public function contactUsAction() {
        return $this->render(':Frontend:contactUs.html.twig', array('page' => $this->getPage('contact-us')));
    }
}
