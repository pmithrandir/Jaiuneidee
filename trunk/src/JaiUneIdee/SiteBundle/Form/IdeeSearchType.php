<?php

namespace JaiUneIdee\SiteBundle\Form;

use JaiUneIdee\SiteBundle\Model\IdeeSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class IdeeSearchType extends AbstractType
{
    private $context;
    private $subsite;

    public function __construct(SecurityContext $context, $subsite)
    {
        $this->context = $context;
        $this->subsite = $subsite;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choice_selected = 'toutes';
        if($this->context->isGranted('ROLE_USER')){
            $choices['local'] = $this->context->getToken()->getUser()->getLocalisation();
            $choice_selected = 'local';
        }
        $choices['toutes'] = 'Toutes les idées';
        $choices['national'] = 'Idées nationales';
        if(!$this->subsite){
            $builder->add('localisation', 'choice', array(
                'choices'   => $choices,
                'required'  => true,
                'multiple'  => false,
                'expanded' => true,
                'data' => $choice_selected,
                'label'=> false
            ));
        }
        $builder->add('theme','entity',array(
                'class'=>'JaiUneIdeeSiteBundle:Theme',
                'required'=>false,
                'label'=> false
            ))
            ->add('search','text',array(
                'label'=> false,
                'required'  => false,
            ))
            ->add('submit','submit',array(
                'label'=> "Chercher"
            ))
            ->add('sort','choice',array(
                'choices' => IdeeSearch::$sortChoices,
                'required'  => true,
                'multiple'  => false,
                'expanded' => true,
                'data' => 'lastAction',
                'label'=> false
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            // avoid to pass the csrf token in the url (but it's not protected anymore)
            'csrf_protection' => false,
            'data_class' => 'JaiUneIdee\SiteBundle\Model\IdeeSearch'
        ));
    }

    public function getName()
    {
        return 'jaiuneidee_sitebundle_idee_search_type';
    }
}