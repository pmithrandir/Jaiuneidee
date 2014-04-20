<?php

namespace JaiUneIdee\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CommentaireAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('content')
            ->add('idee')
            ->add('is_validated_by_admin')
            ->add('life')
            ->add('is_removed')
            ->add('is_moderated')
            ->add('created_at')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('idee')
            ->add('content')
            ->add('life')
            ->add('is_validated_by_admin')
            ->add('is_removed')
            ->add('is_moderated')
            ->add('created_at')
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
            ->add('content')
            ->add('is_validated_by_admin','checkbox',array("required"=>false))
            ->add('life')
            ->add('is_removed','checkbox',array("required"=>false))
            ->add('is_moderated','checkbox',array("required"=>false))
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('content')
            ->add('is_validated_by_admin')
            ->add('life')
            ->add('is_removed')
            ->add('is_moderated')
            ->add('created_at')
            ->add('updated_at')
        ;
    }
}
