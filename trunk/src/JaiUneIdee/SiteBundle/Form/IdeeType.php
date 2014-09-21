<?php

namespace JaiUneIdee\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class IdeeType extends AbstractType
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
            ->add('localisations', 'jaiuneidee_localisation_type', array(
                'label' => 'Zone géographique concernée',
                'required' => true,
                'attr' => array(
                    'class' => 'tokeninput',
                )
            ))
        ;
    }

    public function getName()
    {
        return 'jaiuneidee_sitebundle_ideetype';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('national')
        ));
    }
}
