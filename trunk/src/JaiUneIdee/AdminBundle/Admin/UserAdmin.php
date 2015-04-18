<?php

namespace JaiUneIdee\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends Admin
{
    private function getRoles($originRoles) {
        $roles = array();
        foreach ($originRoles as $roleParent => $rolesHerit) {
            $roles[$roleParent] = $roleParent;
        }
        return $roles;
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('locked')
            ->add('roles')
            ->add('sexe')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
            ->add('created_at')
            ->add('last_activity')
            ->add('newsletter')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('last_activity')
            ->add('roles')
            ->add('sexe')
            ->add('localisation')
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
            ->add('username')
            ->add('email')
            ->add('enabled','checkbox',array("required"=>false))
            ->add('locked','checkbox',array("required"=>false))
            ->add('roles', 'choice', array('choices' => $this->getRoles($this->getConfigurationPool()->getContainer()->getParameter('security.role_hierarchy.roles')), 'multiple' => true, 'expanded' => true))
            ->add('last_activity')
            ->add('sexe')
            ->add('date_de_naissance')
            ->add('dommage')
            ->add('newsletter','checkbox',array("required"=>false))
            ->add('localisation', 'sonata_type_model_autocomplete', array('property'=>'nom'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
            ->add('id')
            ->add('created_at')
            ->add('last_activity')
            ->add('date_de_naissance')
            ->add('date_de_naissance_public')
            ->add('approbation_charte')
            ->add('sexe')
            ->add('sexe_public')
            ->add('localisation')
            ->add('localisation_public')
            ->add('tendance_politique_public')
            ->add('newsletter')
            ->add('dommage')
        ;
    }
}
