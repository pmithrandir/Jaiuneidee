<?php

namespace JaiUneIdee\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class IdeeAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('description')
            ->add('theme')
            ->add('content')
            ->add('is_published')
            ->add('is_removed')
            ->add('created_at')
            ->add('updated_at')
            ->add('is_validated_by_admin')
            ->add('is_moderated')
            ->add('life')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('description')
            ->add('localisations')
            ->add('theme')
            ->add('user')
            ->add('created_at')
            ->add('updated_at')
            ->add('is_published')
            ->add('is_removed')
            ->add('is_validated_by_admin')
            ->add('is_moderated')
            ->add('life')
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
            ->add('id')
            ->add('title')
            ->add('description')
            ->add('theme')
            ->add('content')
            ->add('is_published','checkbox',array("required"=>false))
            ->add('is_removed','checkbox',array("required"=>false))
            ->add('is_validated_by_admin','checkbox',array("required"=>false))
            ->add('is_moderated','checkbox',array("required"=>false))
            ->add('life')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('slug')
            ->add('title')
            ->add('description')
            ->add('localisations')
            ->add('theme')
            ->add('content')
            ->add('is_published')
            ->add('is_removed')
            ->add('created_at')
            ->add('updated_at')
            ->add('is_validated_by_admin')
            ->add('is_moderated')
            ->add('life')
        ;
    }
}
