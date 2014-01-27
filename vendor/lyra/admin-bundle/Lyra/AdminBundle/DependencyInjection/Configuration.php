<?php

/*
 * This file is part of the LyraAdminBundle package.
 *
 * Copyright 2011-2012 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

namespace Lyra\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * Bundle configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('lyra_admin', 'array');

        $rootNode
            ->children()
                ->scalarNode('db_driver')->defaultValue('orm')->cannotBeEmpty()->end()
                ->scalarNode('route_pattern_prefix')->defaultValue('admin')->end()
                ->scalarNode('theme')
                    ->defaultValue('bundles/lyraadmin/css/ui/ui-lightness')
                    ->cannotBeEmpty()
                    ->beforeNormalization()
                        ->ifTrue(function($v) {return !empty($v) && false === strpos($v, '/');})
                        ->then(function($v) {
                            return 'bundles/lyraadmin/css/ui/'.$v;
                        })
                    ->end()
                ->end()
            ->end();

        $this->addActionsSection($rootNode);

        $models = $this->addModelsSection($rootNode);
        $this->addModelFieldsSection($models);
        $this->addModelActionsSection($models);
        $this->addModelShowSection($models);

        $list = $this->addModelListSection($models);
        $this->addModelListColumnsSection($list);
        $this->addModelListActionsSection($list);

        $form = $this->addModelFormSection($models);
        $this->addModelFormGroupsSection($form);
        $this->addModelFormNewSection($form);
        $this->addModelFormEditSection($form);

        $filter = $this->addModelFilterSection($models);
        $this->addModelServicesSection($models);

        return $treeBuilder;
    }

    private function addActionsSection(ArrayNodeDefinition $node)
    {
        $actionDefaults = array(
            'index' => array(
                'route_pattern' => 'list/{page}/{column}/{order}',
                'route_defaults' => array(
                    'page' => null,
                    'column' => null,
                    'order' => null
                ),
                'icon' => 'arrowthick-1-w',
                'text' => 'form.action.back',
                'roles' => array()
            ),
            'new' => array(
                'route_pattern' => 'new',
                'route_defaults' => array(),
                'icon' => 'document',
                'text' => 'list.action.new',
                'trans_domain' => 'LyraAdminBundle',
                'roles' => array()
            ),
            'edit' => array(
                'route_pattern' => '{id}/edit',
                'route_defaults' => array(),
                'icon' => 'pencil',
                'text' => 'list.action.edit',
                'style' => 'icon-only',
                'trans_domain' => 'LyraAdminBundle',
                'roles' => array()
            ),
            'delete' => array(
                'route_pattern' => '{id}/delete',
                'route_defaults' => array(),
                'icon' => 'trash',
                'text' => 'list.action.delete',
                'style' => 'icon-only',
                'trans_domain' => 'LyraAdminBundle',
                'dialog' => array('title' => 'dialog.title.delete', 'message' => 'dialog.message.delete'),
                'roles' => array()
            ),
            'show' => array(
                'route_pattern' => '{id}/show',
                'route_defaults' => array(),
                'icon' => 'document',
                'text' => 'list.action.show',
                'style' => 'icon-only',
                'trans_domain' => 'LyraAdminBundle',
                'roles' => array()
            ),
            'object' => array(
                'route_pattern' => 'object',
                'route_defaults' => array(),
                'roles' => array()
            ),
            'filter' => array(
                'route_pattern' => 'filter/{action}',
                'route_defaults' => array(
                    'action' => null
                ),
                'roles' => array()
            ),
            'save' => array(
                'icon' => 'disk',
                'text' => 'form.button.submit',
                'trans_domain' => 'LyraAdminBundle',
                'roles' => array()
            )
        );

        $node
            ->children()
                ->arrayNode('actions')
                    ->useAttributeAskey('name')
                    ->beforeNormalization()
                        ->always()
                        ->then(function($v) use ($actionDefaults)
                        {
                            $actions = array();

                            foreach ($actionDefaults as $key => $options) {
                                if (isset($v[$key])) {
                                    $actions[$key] = array_merge($options, $v[$key]);
                                } else {
                                    $actions[$key] = $options;
                                }
                            }

                            return $actions;
                        }
                    )
                    ->end()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('route_pattern')->end()
                            ->arrayNode('route_defaults')
                                ->useAttributeAsKey('name')
                                ->prototype('variable')->end()
                            ->end()
                            ->scalarNode('text')->end()
                            ->scalarNode('icon')->end()
                            ->scalarNode('trans_domain')->end()
                            ->arrayNode('dialog')
                                ->children()
                                    ->scalarNode('title')->end()
                                    ->scalarNode('message')->end()
                                ->end()
                            ->end()
                            ->arrayNode('roles')
                                ->prototype('scalar')->end()
                            ->end()
                            ->scalarNode('template')->end()
                            ->scalarNode('style')->end()
                        ->end()
                    ->end()
                    ->defaultValue($actionDefaults)
                ->end()
            ->end();
    }

    private function addModelsSection(ArrayNodeDefinition $node)
    {
       return $node
            ->children()
                ->arrayNode('models')
                ->useAttributeAskey('name')
                ->prototype('array')
                    ->children()
                        ->scalarNode('class')->isRequired()->end()
                        ->scalarNode('controller')->cannotBeEmpty()->defaultValue('LyraAdminBundle:Admin')->end()
                        ->scalarNode('route_prefix')->end()
                        ->scalarNode('route_pattern_prefix')->end()
                        ->scalarNode('trans_domain')->defaultValue('LyraAdminBundle')->end()
                        ->scalarNode('title')->defaultNull()->end()
                    ->end();
    }

    private function addModelFieldsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                 ->arrayNode('fields')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('label')->end()
                            ->scalarNode('type')->end()
                            ->scalarNode('get_method')->end()
                            ->scalarNode('widget')->end()
                            ->arrayNode('options')
                                ->useAttributeAsKey('name')
                                ->prototype('variable')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addModelActionsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('actions')
                    ->useAttributeAskey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('route_pattern')->end()
                            ->arrayNode('route_defaults')
                                ->useAttributeAsKey('name')
                                ->prototype('variable')->end()
                            ->end()
                            ->scalarNode('text')->end()
                            ->scalarNode('icon')->end()
                            ->scalarNode('trans_domain')->end()
                            ->arrayNode('dialog')
                                ->children()
                                    ->scalarNode('title')->end()
                                    ->scalarNode('message')->end()
                                ->end()
                            ->end()
                            ->arrayNode('roles')
                                ->prototype('scalar')->end()
                            ->end()
                            ->scalarNode('template')->end()
                            ->scalarNode('style')->end()
                            ->scalarNode('alias')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addModelShowSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('show')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('title')->defaultValue('show.title')->end()
                    ->scalarNode('auto_labels')->defaultTrue()->end()
                    ->arrayNode('fields')
                        ->useAttributeAskey('name')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('label')->end()
                                ->scalarNode('format')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addModelListSection(ArrayNodeDefinition $node)
    {
        return $node
            ->children()
                ->arrayNode('list')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('template')->cannotBeEmpty()->defaultValue('LyraAdminBundle:List:index.html.twig')->end()
                    ->scalarNode('max_page_rows')->defaultValue(20)->end()
                    ->scalarNode('title')->defaultNull()->end()
                    ->scalarNode('auto_labels')->defaultTrue()->end()
                    ->arrayNode('default_sort')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('column')->defaultNull()->end()
                            ->scalarNode('field')->defaultNull()->end()
                            ->scalarNode('order')->defaultValue('asc')->end()
                        ->end()
                    ->end()
                ->end();
    }

    private function addModelListColumnsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('columns')
                    ->useAttributeAskey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('field')->end()
                            ->scalarNode('type')->defaultNull()->end()
                            ->scalarNode('sortable')->defaultTrue()->end()
                            ->scalarNode('label')->end()
                            ->scalarNode('format')->defaultNull()->end()
                            ->scalarNode('format_function')->defaultNull()->end()
                            ->scalarNode('boolean_actions')->defaultTrue()->end()
                            ->scalarNode('template')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addModelListActionsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('object_actions')
                    ->useAttributeAskey('name')
                    ->defaultValue(array('show' => array(),'edit' => array(),'delete' => array()))
                    ->prototype('array')
                        ->children()
                            ->scalarNode('text')->end()
                            ->scalarNode('icon')->end()
                            ->scalarNode('style')->end()
                        ->end()
                    ->end()
                    ->beforeNormalization()
                        ->always()
                        ->then($this->getNormalizeActionsFunc())
                    ->end()
                ->end()
                ->arrayNode('batch_actions')
                    ->useAttributeAskey('name')
                    ->defaultValue(array('delete' => array()))
                    ->prototype('array')
                        ->children()
                            ->scalarNode('text')->end()
                        ->end()
                    ->end()
                    ->beforeNormalization()
                        ->always()
                        ->then($this->getNormalizeActionsFunc())
                    ->end()
                ->end()
                ->arrayNode('list_actions')
                    ->useAttributeAskey('name')
                    ->defaultValue(array('new' => array()))
                    ->prototype('array')
                        ->children()
                            ->scalarNode('text')->end()
                            ->scalarNode('icon')->end()
                            ->scalarNode('style')->end()
                        ->end()
                    ->end()
                    ->beforeNormalization()
                        ->always()
                        ->then($this->getNormalizeActionsFunc())
                    ->end()
                ->end()
            ->end();
    }

    private function addModelFormSection(ArrayNodeDefinition $node)
    {
        return $node
            ->children()
                ->arrayNode('form')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('template')->cannotBeEmpty()->defaultValue('LyraAdminBundle:Form:form.html.twig')->end()
                    ->scalarNode('class')->cannotBeEmpty()->defaultValue('Lyra\AdminBundle\Form\Type\AdminFormType')->end()
                ->end();
    }

    private function addModelFormGroupsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('groups')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('caption')->defaultNull()->end()
                            ->scalarNode('break_after')->defaultFalse()->end()
                            ->scalarNode('embed')->end()
                            ->arrayNode('fields')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addModelFormNewSection(ArrayNodeDefinition $node)
    {
        $new = $node
            ->children()
                ->arrayNode('new')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('title')->defaultValue('New')->end()
                        ->arrayNode('actions')
                            ->useAttributeAskey('name')
                            ->defaultValue(array('index' => array(), 'save' => array()))
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('text')->end()
                                    ->scalarNode('icon')->end()
                                    ->scalarNode('style')->end()
                                ->end()
                            ->end()
                            ->beforeNormalization()
                                ->always()
                                ->then($this->getNormalizeActionsFunc())
                            ->end()
                        ->end()
                    ->end();
        $this->addModelFormGroupsSection($new);
    }

    private function addModelFormEditSection(ArrayNodeDefinition $node)
    {
        $edit = $node
            ->children()
                ->arrayNode('edit')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('title')->defaultValue('Edit')->end()
                        ->arrayNode('actions')
                            ->useAttributeAskey('name')
                            ->defaultValue(array('index' => array(), 'save' => array(), 'delete' => array()))
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('text')->end()
                                    ->scalarNode('icon')->end()
                                    ->scalarNode('style')->end()
                                ->end()
                            ->end()
                            ->beforeNormalization()
                                ->always()
                                ->then($this->getNormalizeActionsFunc())
                            ->end()
                        ->end()
                    ->end();
        $this->addModelFormGroupsSection($edit);
    }

    private function addModelFilterSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('filter')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('title')->defaultValue('Filter')->end()
                        ->arrayNode('fields')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('widget')->end()
                                    ->arrayNode('options')
                                        ->useAttributeAsKey('name')
                                        ->prototype('variable')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addModelServicesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('services')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('model_manager')->defaultValue('lyra_admin.model_manager.abstract')->end()
                ->end()
            ->end();
    }

    private function getNormalizeActionsFunc()
    {
        return function($v)
        {
            $norm = array();
            foreach ($v as $key => $val) {
                if (is_int($key) && is_string($val)) {
                    $norm[$val] = array();
                } else {
                    $norm[$key] = $val;
                }
            }

            return $norm;
        };
    }
}
