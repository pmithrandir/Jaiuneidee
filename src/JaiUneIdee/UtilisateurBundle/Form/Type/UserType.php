<?php

namespace JaiUneIdee\UtilisateurBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class UserType extends BaseType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('localisation', 'jaiuneidee_localisation_type', array(
            		'label' => 'Votre Ville',
			        'required' => true,
					'attr' => array(
			            'class' => 'tokeninput_unique',
			        )
			    ))
            ->add('localisation_recherchee', 'jaiuneidee_localisation_type', array(
            		'label' => 'Votre localisation préférée',
			        'required' => false,
					'attr' => array(
			            'class' => 'tokeninput_unique',
			        )
			    ))
        ;
    }
    public function getName()
    {
        return 'jaiuneidee_utilisateurbundle_usertype';
    }
}
