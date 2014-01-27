<?php

/*
 * This file is part of the LyraAdminBundle package.
 *
 * Copyright 2011-2012 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

namespace Lyra\AdminBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Lyra\AdminBundle\DependencyInjection\LyraAdminExtension;
use Symfony\Component\Yaml\Parser;

class LyraAdminExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testThrowsExceptionUnlessClassSet()
    {
        $yaml = <<<EOF
models:
    test:
        controller: AcmeMyBundle:Test
EOF;
        $config = $this->getConfiguration($yaml);
    }

    public function testClassParameter()
    {
        $config = $this->getConfiguration();
        $this->assertEquals('Lyra\AdminBundle\Tests\Fixture\Entity\Dummy', $config->getParameter('lyra_admin.test.class'));
    }

    public function testDefaultActions()
    {
        $config = $this->getConfiguration();
        $options = $config->getParameter('lyra_admin.test.options');
        $this->assertEquals($options['actions'], $this->getActionDefaults());
    }

    public function testOverrideAction()
    {
       $yaml = <<<EOF
actions:
    edit:
        icon: dummy
EOF;

        $config = $this->getConfiguration($yaml);
        $options = $config->getParameter('lyra_admin.options');

        $this->assertEquals('dummy', $options['actions']['edit']['icon']);
    }

    public function testOverrideModelAction()
    {
        $yaml = <<<EOF
models:
    test:
        class: Lyra\AdminBundle\Tests\Fixture\Entity\Dummy
        actions:
            new:
                icon: dummy
            delete:
                route_pattern: dummy
EOF;

        $config = $this->getConfiguration($yaml);
        $defaults = $this->getActionDefaults();
        $defaults['new']['icon'] = 'dummy';
        $defaults['delete']['route_pattern'] = 'dummy';

        $options = $config->getParameter('lyra_admin.test.options');
        $this->assertEquals($options['actions'], $defaults);
    }

    public function testDefaultActionsInList()
    {
        $yaml = <<<EOF
models:
    test:
        class: Lyra\AdminBundle\Tests\Fixture\Entity\Dummy
        actions:
            new:
                icon: new-icon
                text: new-text
                style: icon-text
            edit:
                icon: edit-icon
                text: edit-text
                style: icon-text
            delete:
                text: delete-text
        list:
            list_actions: [new]
            object_actions: [edit]
            batch_actions: [delete]
EOF;
        $config = $this->getConfiguration($yaml);
        $options = $config->getParameter('lyra_admin.test.options');

        $this->assertEquals('new-icon', $options['list']['list_actions']['new']['icon']);
        $this->assertEquals('new-text', $options['list']['list_actions']['new']['text']);
        $this->assertEquals('icon-text', $options['list']['list_actions']['new']['style']);
        $this->assertEquals('edit-icon', $options['list']['object_actions']['edit']['icon']);
        $this->assertEquals('edit-text', $options['list']['object_actions']['edit']['text']);
        $this->assertEquals('icon-text', $options['list']['object_actions']['edit']['style']);
        $this->assertEquals('delete-text', $options['list']['batch_actions']['delete']['text']);
    }

    public function testOverrideModelActionInList()
    {
        $yaml = <<<EOF
models:
    test:
        class: Lyra\AdminBundle\Tests\Fixture\Entity\Dummy
        actions:
            new:
                icon: act-new
            delete:
                icon: act-delete
        list:
            list_actions:
                new:
                    icon: list-new
            object_actions:
                delete:
                    icon: list-delete
EOF;

        $config = $this->getConfiguration($yaml);
        $options = $config->getParameter('lyra_admin.test.options');

        $this->assertEquals('list-delete', $options['list']['object_actions']['delete']['icon']);
        $this->assertEquals('list-new', $options['list']['list_actions']['new']['icon']);
    }

    public function testNormalizeThemeOption()
    {
        $yaml = <<<EOF
theme: smoothness
EOF;

        $config = $this->getConfiguration($yaml);

        $options = $config->getParameter('lyra_admin.options');
        $this->assertEquals('bundles/lyraadmin/css/ui/smoothness', $options['theme']);

        $yaml = <<<EOF
theme: css/ui/redmond
EOF;

        $config = $this->getConfiguration($yaml);
        $options = $config->getParameter('lyra_admin.options');
        $this->assertEquals('css/ui/redmond', $options['theme']);
    }

    protected function getActionDefaults()
    {
        return array(
            'index' => array(

                'route_pattern' => 'list/{page}/{column}/{order}',
                'route_defaults' => array(
                    'page' => null,
                    'column' => null,
                    'order' => null
                ),
                'icon' => 'arrowthick-1-w',
                'text' => 'form.action.back',
                'roles' => array(),
                'route_name' => 'lyra_admin_test_index'
            ),
            'new' => array(
                'route_pattern' => 'new',

                'route_defaults' => array(),
                'icon' => 'document',
                'text' => 'list.action.new',
                'trans_domain' => 'LyraAdminBundle',
                'roles' => array(),
                'route_name' => 'lyra_admin_test_new'
            ),
            'edit' => array(

                'route_pattern' => '{id}/edit',
                'route_defaults' => array(),
                'icon' => 'pencil',
                'text' => 'list.action.edit',
                'style' => 'icon-only',
                'trans_domain' => 'LyraAdminBundle',
                'roles' => array(),
                'route_name' => 'lyra_admin_test_edit'
            ),
            'delete' => array(

                'route_pattern' => '{id}/delete',
                'route_defaults' => array(),
                'icon' => 'trash',
                'text' => 'list.action.delete',
                'style' => 'icon-only',
                'trans_domain' => 'LyraAdminBundle',
                'dialog' => array('title' => 'dialog.title.delete', 'message' => 'dialog.message.delete'),
                'roles' => array(),
                'route_name' => 'lyra_admin_test_delete'
            ),
            'show' => array(

                'route_pattern' => '{id}/show',
                'route_defaults' => array(),
                'icon' => 'document',
                'text' => 'list.action.show',
                'style' => 'icon-only',
                'trans_domain' => 'LyraAdminBundle',
                'roles' => array(),
                'route_name' => 'lyra_admin_test_show'
            ),
            'object' => array(
                'route_pattern' => 'object',
                'route_defaults' => array(),
                'roles' => array(),
                'route_name' => 'lyra_admin_test_object'
            ),
            'filter' => array(
                'route_pattern' => 'filter/{action}',
                'route_defaults' => array(
                    'action' => null
                ),
                'roles' => array(),
                'route_name' => 'lyra_admin_test_filter'
            ),
            'save' => array(
                'icon' => 'disk',
                'text' => 'form.button.submit',
                'trans_domain' => 'LyraAdminBundle',
                'roles' => array()
            )
        );
    }

    protected function getConfiguration($yaml = null)
    {
        if (null === $yaml) {

        $yaml = <<<EOF
models:
    test:
        class: Lyra\AdminBundle\Tests\Fixture\Entity\Dummy
        controller: AcmeMyBundle:Test
EOF;
        }

        $parsed = $this->parseConfiguration($yaml);
        $loader = new LyraAdminExtension();
        $configuration = new ContainerBuilder();
        $loader->load(array($parsed), $configuration);
        $loader->configureFromMetadata($configuration);

        return $configuration;
    }

    protected function parseConfiguration($yaml)
    {
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
