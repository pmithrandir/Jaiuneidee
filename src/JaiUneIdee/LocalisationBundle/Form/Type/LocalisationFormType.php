<?php

namespace JaiUneIdee\LocalisationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use JaiUneIdee\LocalisationBundle\Form\DataTransformer\LocalisationsToIdsTransformer;

class LocalisationFormType extends AbstractType
{
    protected $localisationTransformer;

    public function __construct(LocalisationsToIdsTransformer $localisationTransformer)
    {
        $this->localisationTransformer = $localisationTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this->localisationTransformer,true);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'class' => 'JaiUneIdee\LocalisationBundle\Entity\Localisation'
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'jaiuneidee_localisation_type';
    }
}