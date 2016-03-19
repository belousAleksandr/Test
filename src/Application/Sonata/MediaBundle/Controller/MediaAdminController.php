<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Aleksandr
 * Date: 5/10/13
 * Time: 11:29 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Sonata\MediaBundle\Controller;

use Application\Sonata\MediaBundle\Entity\Gallery;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\AdminBundle\Admin\Pool;
use Sonata\MediaBundle\Controller\MediaAdminController as Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MediaAdminController extends Controller{

    /**
     * This method can be overloaded in your custom CRUD controller.
     * It's called from createAction.
     *
     * @param Request $request
     * @param mixed   $object
     *
     * @return Response|null
     */
    protected function preCreate(Request $request, $object)
    {
        $parentCode = $request->get('parentCode');
        $parentId = $request->get('parentId');

        $this->admin->addUrlParams['parentCode'] = $parentCode;
        $this->admin->addUrlParams['parentId'] = $parentId;

        /** @var Pool $pool */
        $pool = $this->admin->getConfigurationPool();
        $parentAdmin = $pool->getAdminByAdminCode($parentCode);
        $parentAdmin->setRequest($request);
        $subject = $parentAdmin->getObject($parentId);

        if (false === $parentAdmin->isGranted('EDIT', $subject)) {
            throw new AccessDeniedException();
        }

        /** @var Gallery $gallery */
        $gallery = $subject->getGallery();
        $galleryHasMedia = new GalleryHasMedia();
        $galleryHasMedia->setMedia($object);
        $galleryHasMedia->setEnabled(true);
        $gallery->addGalleryHasMedias($galleryHasMedia);
    }

    /**
     * This method can be overloaded in your custom CRUD controller.
     * It's called from editAction.
     *
     * @param Request $request
     * @param mixed   $object
     *
     * @return Response|null
     */
    protected function preEdit(Request $request, $object)
    {
        $parentCode = $request->get('parentCode');
        $parentId = $request->get('parentId');

        $this->admin->addUrlParams['parentCode'] = $parentCode;
        $this->admin->addUrlParams['parentId'] = $parentId;

        /** @var Pool $pool */
        $pool = $this->admin->getConfigurationPool();
        $parentAdmin = $pool->getAdminByAdminCode($parentCode);
        $parentAdmin->setRequest($request);
        $subject = $parentAdmin->getObject($parentId);

        if (false === $parentAdmin->isGranted('EDIT', $subject)) {
            throw new AccessDeniedException();
        }
    }

    /**
     * This method can be overloaded in your custom CRUD controller.
     * It's called from deleteAction.
     *
     * @param Request $request
     * @param Media  $object
     *
     * @return Response|null
     */
    protected function preDelete(Request $request, $object)
    {
        $parentCode = $request->get('parentCode');
        $parentId = $request->get('parentId');

        $this->admin->addUrlParams['parentCode'] = $parentCode;
        $this->admin->addUrlParams['parentId'] = $parentId;

        /** @var Pool $pool */
        $pool = $this->admin->getConfigurationPool();
        $parentAdmin = $pool->getAdminByAdminCode($parentCode);
        $parentAdmin->setRequest($request);
        $subject = $parentAdmin->getObject($parentId);

        if (false === $parentAdmin->isGranted('EDIT', $subject)) {
            throw new AccessDeniedException();
        }

        /** @var Gallery $gallery */
        $gallery = $subject->getGallery();
        $manager = $this->getDoctrine()->getManager();

        /** @var GalleryHasMedia $galleryHasMedia */
        foreach ($gallery->getGalleryHasMedias() as $galleryHasMedia) {
            if($galleryHasMedia->getMedia()->getId() == $object->getId()){
                $galleryHasMedia->setGallery();
                $manager->remove($galleryHasMedia);
            }
        }

    }



}