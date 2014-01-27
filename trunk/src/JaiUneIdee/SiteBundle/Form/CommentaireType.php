<?php

namespace JaiUneIdee\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content',"textarea", array(
            		'label'=>'Message',
			        'label_attr' => array(
			         //   'class' => 'tinymce',
			         //   'data-theme' => 'medium' // simple, advanced, bbcode
			        )
    		))
        ;
    }

    public function getName()
    {
        return 'jaiuneidee_sitebundle_commentairetype';
    }
}
