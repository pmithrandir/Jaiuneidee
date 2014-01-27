<?php

namespace JaiUneIdee\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sujet')
            ->add('message')
            //->add('created_at')
            //->add('userFrom')
            ->add('userTo')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JaiUneIdee\SiteBundle\Entity\Message'
        ));
    }

    public function getName()
    {
        return 'jaiuneidee_sitebundle_messagetype';
    }
}
