<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Form\Type;

use Sonata\CoreBundle\Form\Type\BooleanType;
use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooleanTypeTest extends TypeTestCase
{
    public function testGetDefaultOptions()
    {
        $type = new BooleanType();

        $optionResolver = new OptionsResolver();

        $this->assertEquals('sonata_type_translatable_choice', $type->getParent());

        $type->setDefaultOptions($optionResolver);

        $options = $optionResolver->resolve();

        $this->assertEquals(2, count($options['choices']));
    }

    public function testAddTransformerCall()
    {
        $type = new BooleanType();

        $type->setDefaultOptions($optionResolver = new OptionsResolver());

        $builder = $this->getMock('Symfony\Component\Form\Test\FormBuilderInterface');
        $builder->expects($this->once())->method('addModelTransformer');

        $type->buildForm($builder, $optionResolver->resolve(array(
            'transform' => true,
        )));
    }

    /**
     * The default behavior is not to transform to real boolean value .... don't ask
     *
     */
    public function testDefaultBehavior()
    {
        $type = new BooleanType();

        $type->setDefaultOptions($optionResolver = new OptionsResolver());

        $builder = $this->getMock('Symfony\Component\Form\Test\FormBuilderInterface');
        $builder->expects($this->never())->method('addModelTransformer');

        $type->buildForm($builder, $optionResolver->resolve(array()));
    }
}
