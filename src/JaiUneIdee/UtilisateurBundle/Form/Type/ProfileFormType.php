<?php

namespace JaiUneIdee\UtilisateurBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options);
        $builder
            ->add('date_de_naissance', 'birthday', array(
                    'format' => 'd-M-y',
                    'pattern' => "{{ day }}/{{ month }}/{{ year }}", 
                    'years' => range(date('Y'), date('Y') - 110),
                    'required' => true,
                )
            )
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
            'required' => true,
        ))
        ->add('sexe_public', 'checkbox', array(
            		'label' => "Publier mon sexe",
					'label_attr' => array(
			            'class' => 'checkbox_meme_ligne',
			        ),
            		'required' => false,
			)
		)
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
    	->add('localisation', 'jaiuneidee_localisation_type', array(
            		'label' => 'La zone géographique qui vous intéresse',
			        'required' => true,
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
        ->add('newsletter', 'checkbox', array(
            		'label' => "S'abonner aux news",
					'label_attr' => array(
			            'class' => 'checkbox_meme_ligne',
			        ),
            		'required' => false,
			)
		)
        ->remove('avatar')
        ->remove('current')
        ->remove('invitation')
        ->remove('approbation_charte')
        ;
    }

    public function getName()
    {
        return 'jaiuneidee_user_profile_edit';
    }
}