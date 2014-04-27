<?php

namespace JaiUneIdee\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class NewsAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('publication_date')
            ->add('content')
            ->add('is_validated_by_admin')
            ->add('is_removed')
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('content')
            ->add('is_validated_by_admin')
            ->add('is_removed')
            ->add('publication_date')
            ->add('created_at')
            ->add('updated_at')
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
        $formMapper
            ->add('content')
            ->add('is_validated_by_admin','checkbox',array("required"=>false))
            ->add('is_removed','checkbox',array("required"=>false))
            ->add('publication_date')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('content')
            ->add('is_validated_by_admin')
            ->add('is_removed')
            ->add('publication_date')
            ->add('created_at')
            ->add('updated_at')
        ;
    }
}
