<?php

namespace ShopBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PageAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('key')
            ->add('name')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formBuilder = $formMapper->getFormBuilder();
        $formMapper
             ->add('key')
             ->add('title')
             ->add('name')
            ->add('mKeywords')
            ->add('mDescription')
            ->add('content', null, array(
                'attr' => array('class' => 'ckeditor')
//                'source_field' => 'rawContent',
//                'target_field' => 'content'
            ))
//             ->add('content', 'sonata_formatter_type', array(
//                 'event_dispatcher' => $formBuilder->getEventDispatcher(),
//                 'format_field'   => 'contentFormatter',
//                 'source_field'   => 'content',
//                 'source_field_options'      => array(
//                     'attr' => array('class' => 'span10', 'rows' => 20)
//                 ),
//                 'listener'       => true,
//                 'target_field'   => 'content'
//             ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
        ;
    }
}
