<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\MediaBundle\Admin;

use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\MediaBundle\Admin\BaseMediaAdmin;
use Sonata\MediaBundle\Form\DataTransformer\ProviderDataTransformer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MediaAdmin extends BaseMediaAdmin
{

    protected  $translationDomain = 'Admin';
    public $addUrlParams = array();


    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
	    /** @var Media $media */
        $media = $this->getSubject();

        $request = $this->getRequest();
        if (!$media) {
            $media = $this->getNewInstance();
        }

	    if ($media and !$media->getProviderName()) {
		    $providerName = $request->get('provider');
		    $media->setProviderName($providerName);
	    }


	    if (!$media || !$media->getProviderName()) {
		    return;
	    }

        $formMapper->getFormBuilder()->addModelTransformer(new ProviderDataTransformer($this->pool, $this->getClass()), true);

        $provider = $this->pool->getProvider($media->getProviderName());

        if ($media->getId()) {
            $provider->buildEditForm($formMapper);

            $formMapper
                ->remove('name')
                ->remove('enabled')
                ->remove('description')
                ->remove('authorName')
                ->remove('copyright')
                ->remove('cdnIsFlushable')
            ;
        } else {
            $provider->buildCreateForm($formMapper);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function generateUrl($name, array $parameters = array(), $absolute = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
//
//        var_dump($this->addUrlParams);
//        die;
        $parameters = array_merge($parameters, $this->addUrlParams);
        return parent::generateUrl($name, $parameters, $absolute);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create', 'delete', 'edit', 'list'));

    }
}
