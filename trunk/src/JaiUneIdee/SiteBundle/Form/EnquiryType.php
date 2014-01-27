<?php
// src/JaiUneIdee/SiteBundle/Form/EnquiryType.php

namespace JaiUneIdee\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label' => 'contact.name'));
        $builder->add('email', 'email', array('label' => 'contact.email'));
        $builder->add('subject', 'text', array('label' => 'contact.subject'));
        $builder->add('body', 'textarea', array('label' => 'contact.body'));
    }
    

    public function getName()
    {
        return 'contact';
    }
}