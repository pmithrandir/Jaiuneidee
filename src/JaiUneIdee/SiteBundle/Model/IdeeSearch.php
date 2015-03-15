<?php

namespace JaiUneIdee\SiteBundle\Model;

use Symfony\Component\HttpFoundation\Request;

class IdeeSearch
{
    // begin of publication range
    protected $theme;

    // end of publication range
    //protected $order;

    // published or not
    protected $localisation;
    protected $localisationObject;
    protected $withChildrenLoc;

    protected $search;
    
    public static $sortChoices = array(
        'lastAction' => 'Dernière activité',
        'updatedAt' => 'Date de création',
        'countCommentaires'=> ' Buzz',
    );
    protected $sort = 'lastAction';
    
    public function __construct()
    {
    }
    public function getTheme()
    {
        return $this->theme;
    }

    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }
    public function getSearch()
    {
        return $this->search;
    }

    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }
    public function getLocalisation()
    {
        return $this->localisation;
    }

    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }
    function getLocalisationObject() {
        return $this->localisationObject;
    }

    function getWithChildrenLoc() {
        return $this->withChildrenLoc;
    }

    function setLocalisationObject($localisationOject) {
        $this->localisationObject = $localisationOject;
        return $this;
    }

    function setWithChildrenLoc($withChildrenLoc) {
        $this->withChildrenLoc = $withChildrenLoc;
        return $this;
    }
    function getSort() {
        return $this->sort;
    }

    function setSort($sort) {
        $this->sort = $sort;
        return $this;
    }



}