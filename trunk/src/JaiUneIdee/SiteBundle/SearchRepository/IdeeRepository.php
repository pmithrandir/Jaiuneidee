<?php

namespace JaiUneIdee\SiteBundle\SearchRepository;

use FOS\ElasticaBundle\Repository;
use JaiUneIdee\SiteBundle\Model\IdeeSearch;

class IdeeRepository extends Repository
{
    /**
     * @param $ideeSearch
     * @return array<Idee>
     */
    public function searchQuery(IdeeSearch $ideeSearch)
    {
//        $boolQuery = new \Elastica\Query\Bool();
        if($ideeSearch->getSearch() != ''){
            $query_part = new \Elastica\Query\Bool();
            $query_part_title = new \Elastica\Query\Match();
            $query_part_title->setFieldQuery('title', $ideeSearch->getSearch());
            $query_part_title->setFieldOperator('title', 'and');
            $query_part_desc = new \Elastica\Query\Match();
            $query_part_desc->setFieldQuery('description', $ideeSearch->getSearch());
            $query_part_desc->setFieldOperator('description', 'and');
            $query_part_content = new \Elastica\Query\Match();
            $query_part_content->setFieldQuery('content', $ideeSearch->getSearch());
            $query_part_content->setFieldOperator('content', 'and');
            $query_part->addShould($query_part_title);
            $query_part->addShould($query_part_desc);
            $query_part->addShould($query_part_content);
        }
        else{
            $query_part = new \Elastica\Query\MatchAll();
        }
        
        $filters = new \Elastica\Filter\Bool();
//        }
//        if ($ideeSearch != null && $ideeSearch->getSearch() != '') {
//            
//            $fieldQuery = new \Elastica\Filter\Terms(array('title' => array('value'=>"forme")));
//            //$fieldQuery->setFieldParam('title', 'analyzer', 'my_analyzer');
//            $boolQuery->addMust($fieldQuery);
//        }
        
        if($ideeSearch->getTheme() !== null){
            $filters->addMust(
                new \Elastica\Filter\Term(array('theme'=>strtolower($ideeSearch->getTheme()->getNom())))
            );
        }
        if($ideeSearch->getWithChildrenLoc()===true){
            $filters->addMust(
                new \Elastica\Filter\Term(array('localisationsNiveau'.$ideeSearch->getLocalisationObject()->getNiveau()=>strtolower($ideeSearch->getLocalisationObject()->getNom())))
            );
        }
        else {
            $filters->addMust(
                new \Elastica\Filter\Term(array('localisations'=>strtolower($ideeSearch->getLocalisationObject()->getNom())))
            );
        }
        $filters->addMust(
            new \Elastica\Filter\Term(array('isVisible'=>true))
        );
        $filtered = new \Elastica\Query\Filtered($query_part, $filters);
        
        $query = new \Elastica\Query($filtered);
        $query->setSort(array(
            $ideeSearch->getSort() => array(
                'order' => 'desc'
            )
        ));
//        $query = \Elastica\Query::create($filtered);
//        return $this->find($query);
        return $query;   
    }
    /**
     * @param $ideeSearch
     * @return array<Idee>
     */
    public function findTransformed(IdeeSearch $ideeSearch)
    {
        return $this->find($this->searchQuery($ideeSearch));
    }
    /**
     * @param $ideeSearch
     * @return array<Idee>
     */
    public function findTransformedHybrid(IdeeSearch $ideeSearch)
    {
        return $this->findHybrid($this->searchQuery($ideeSearch));
    }
    /**
     * @param $ideeSearch
     * @return array<Idee>
     */
    public function searchES(IdeeSearch $ideeSearch)
    {
        return $this->findRawResult($this->searchQuery($ideeSearch));
    }
}