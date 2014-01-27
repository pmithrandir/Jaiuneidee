<?php

namespace JaiUneIdee\UtilisateurBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('Avatar', 'file', array('data_class'=>null))
        ;
    }
    public function getName()
    {
        return 'jaiuneidee_user_avatar_edit';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('avatar')
        ));
    }

}