<?php

namespace JaiUneIdee\UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('id')
            ->add('email')
            //->add('sent')
            //->add('user')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JaiUneIdee\UtilisateurBundle\Entity\Invitation'
        ));
    }

    public function getName()
    {
        return 'jaiuneidee_utilisateurbundle_invitationtype';
    }
}
