<?php

/*
 * This file is part of the LyraAdminBundle package.
 *
 * Copyright 2011-2012 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

namespace Lyra\AdminBundle\Grid;

use Lyra\AdminBundle\UserState\UserStateInterface;
use Lyra\AdminBundle\Action\ActionCollectionInterface;

interface GridInterface
{
    /**
     * Sets the model name.
     *
     * @param string $modelName
     */
    function setModelName($modelName);

    /**
     * Gets the model name.
     *
     * @return string
     */
    function getModelName();

    /**
     * Sets user state service.
     *
     * @param \Lyra\AdminBundle\UserState\UserStateInterface $state
     */
    function setState(UserStateInterface $state);

    /**
     * Gets user state service.
     *
     * @return \Lyra\AdminBundle\UserState\UserStateInterface
     */
    function getState();

    /**
     * Sets list template.
     *
     * @param string $template
     */
    function setTemplate($template);

    /**
     * Gets list template.
     *
     * @return string
     */
    function getTemplate();

    /**
     * Sets list title (header).
     *
     * @param string $title
     */
    function setTitle($title);

    /**
     * Gets list title (header).
     *
     * @return string
     */
    function getTitle();

    /**
     * Sets the list translation domain.
     *
     * Used in templates to translate list title, headers.
     *
     * @param string $transDomain
     */
    function setTransDomain($transDomain);

    /**
     * Gets the list translation domain.
     *
     * @return string
     */
    function getTransDomain();

    /**
     * Sets list column collection.
     *
     * @param \Lyra\AdminBundle\Grid\ColumnCollectionInterface $columns
     */
    function setColumns(ColumnCollectionInterface $columns);

    /**
     * Gets list column collection.
     *
     * @return array
     */
    function getColumns();

    /**
     * Gets a list column.
     *
     * @param string $columnName
     *
     * @return \Lyra\AdminBundle\Grid\ColumnInterface
     */
    function getColumn($columnName);

    /**
     * Sets list batch actions names.
     *
     * @param \Lyra\AdminBundle\Action\ActionCollectionInterface $actions
     */
    function setBatchActions(ActionCollectionInterface $actions);

    /**
     * Gets list batch actions names.
     *
     * @return \Lyra\AdminBundle\Action\ActionCollectionInterface
     */
    function getBatchActions();

    /**
     * Checks if list has batch actions.
     *
     * @return boolean
     */
    function hasBatchActions();

    /**
     * Sets list object action.
     *
     * @param \Lyra\AdminBundle\Action\ActionCollectionInterface $actions
     */
    function setObjectActions(ActionCollectionInterface $actions);

    /**
     * Gets list object actions.
     *
     * @return \Lyra\AdminBundle\Action\ActionCollectionInterface
     */
    function getObjectActions();

    /**
     * Sets list actions.
     *
     * @param \Lyra\AdminBundle\Action\ActionCollectionInterface $actions
     */
    function setListActions(ActionCollectionInterface $actions);

    /**
     * Gets list actions.
     *
     * @return \Lyra\AdminBundle\Action\ActionCollectionInterface
     */
    function getListActions();

    /**
     * Sets list other actions.
     *
     * @param \Lyra\AdminBundle\Action\ActionCollectionInterface $actions
     */
    function setActions(ActionCollectionInterface $actions);

    /**
     * Gets list other actions.

     *
     * @return \Lyra\AdminBundle\Action\ActionCollectionInterface
     */
    function getActions();

    /**
     * Sets current sort column and sort direction (asc/desc).
     *
     * @param array $sort array('column' => $sortCol, 'order' => $sortDir)
     */
    function setSort(array $sort);

    /**
     * Gets current sort column and sort direction (asc/desc).
     *
     * @return array array('column' => $sortCol, 'order' => $sortDir)
     */
    function getSort();
}
