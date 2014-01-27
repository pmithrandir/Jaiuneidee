<?php
namespace JaiUneIdee\AdminBundle\Model;

use Lyra\AdminBundle\Model\ORM\ModelManager as BaseManager;

class UserManager extends BaseManager
{
    // ...
    /*
    public function getBaseListQueryBuilder()
    {
        $qb = parent::getBaseListQueryBuilder();
        $qb->select('a');
        $qb->leftJoin('a.sexe', 'sexe');

        return $qb;
    }*/
}