<?php

namespace JaiUneIdee\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class IdeeLocalisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'idee.title'))
            ->add('description', 'text', array('label' => 'idee.description'))
            ->add('content',"textarea", array(
            		'label' => 'idee.content',
			        'label_attr' => array(
			           // 'class' => 'tinymce',
			           // 'data-theme' => 'medium' // simple, advanced, bbcode
			        )
    		))
            ->add('theme')
        ;
    }

    public function getName()
    {
        return 'jaiuneidee_sitebundle_ideelocalisationtype';
    }
}
