<?php

namespace ShopBundle\Twig\Extension;

use Sonata\AdminBundle\Admin\Pool;

class AdminHelpExtension extends \Twig_Extension
{

    /**
     * @var \Sonata\AdminBundle\Admin\Pool
     */
    protected $pool;

    /**
     * @param Pool $pool
     */
    public function __construct( Pool $pool)
    {
        $this->pool   = $pool;
    }
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getAdmin', array($this, 'getAdmin'))
        );
    }

    public function getFilters()
    {
        return array();
    }

    /**
     * @param $adminCode
     * @return null|\Sonata\AdminBundle\Admin\AdminInterface
     */
    public function getAdmin($adminCode) {
        return $this->pool->getAdminByAdminCode($adminCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin_help';
    }
}
