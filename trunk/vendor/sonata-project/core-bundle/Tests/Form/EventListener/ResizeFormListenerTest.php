<?php

/*
* This file is part of the "Outil Auteur" project.
*
* (c) 2014 - DED (CanalPlus Group)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Sonata\CoreBundle\Tests\Form\EventListener;

use Sonata\CoreBundle\Form\EventListener\ResizeFormListener;
use Symfony\Component\Form\FormEvent;

/**
 * Class ResizeFormListenerTest
 *
 * @package Sonata\CoreBundle\Tests\Form\EventListener
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class ResizeFormListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testPreBindClosure()
    {
        $form = $this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();

        $value = array('value1', 'value2');
        $data  = array($value);

        $event = new FormEvent($form, $data);

        $closure = function ($listenerValue) use ($value) {
            $this->assertEquals($value, $listenerValue);
        };

        $listener = new ResizeFormListener('form', array(), false, $closure);

        $listener->preBind($event);
    }
}
