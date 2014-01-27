<?php

namespace JaiUneIdee\UtilisateurBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // Ajoutez vos champs ici, revoilà notre champ *signature* :
        //$builder->add('date_de_naissance', "birthday", array('label' => 'Date de Naissance'));
	$builder->add('date_de_naissance', 'birthday', array('format' => 'd-M-y','pattern' => "{{ day }}/{{ month }}/{{ year }}", 'years' => range(date('Y'), date('Y') - 110)))
                
        ->add('date_de_naissance_public', 'checkbox', array(
            		'label' => "Publier ma date de naissance",
					'label_attr' => array(
			            'class' => 'checkbox_meme_ligne',
			        ),
            'required' => false,
			)
		)
    	->add('sexe', 'entity',
	    	 array(
				'empty_value' => 'Sélectionner',
	            'class' => 'JaiUneIdeeUtilisateurBundle:Sexe',
	            'required' => false,
	        ))
        ->add('sexe_public', 'checkbox', array(
            		'label' => "Publier mon sexe",
					'label_attr' => array(
			            'class' => 'checkbox_meme_ligne',
			        ),
            		'required' => false,
			)
		)/*
    	->add('tendance_politique', 'entity',
	    	 array(
                    'label' => "Tendance politique (optionnel)",
                    'empty_value' => 'Sélectionner',
	            'class' => 'JaiUneIdeeUtilisateurBundle:TendancePolitique',
	            'required' => false,
	        ))
        ->add('tendance_politique_public', 'checkbox', array(
            		'label' => "Publier mes tendances politiques",
					'label_attr' => array(
			            'class' => 'checkbox_meme_ligne',
			        ),
            		'required' => false,
			)
		)
                */
         ->add('localisation', 'jaiuneidee_localisation_type', array(
            		'label' => "La zone géographique qui vous intéresse",
                        'required' => false,
                        'attr' => array(
                            'class' => 'tokeninput_unique',
                        )
                    ))
        ->add('localisation_public', 'checkbox', array(
            		'label' => "Publier ma localisation",
					'label_attr' => array(
			            'class' => 'checkbox_meme_ligne',
			        ),
            		'required' => false,
			)
		)
        ->add('invitation', 'jaiuneidee_invitation_type', array(
            		'label' => "Code de parrainage (optionnel)",
                        'required' => false,
			    ))
        ->add('approbation_charte', 'checkbox', array(
            		'label' => "J'ai lu et j'approuve la charte du site.",
					'label_attr' => array(
			            'class' => 'checkbox_meme_ligne',
			        )
			)
		)
        ;
    }

    public function getName()
    {
        return 'jaiuneidee_user_registration';
    }
}