<?php

namespace App\SearchRepository;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FOS\ElasticaBundle\Repository;


class CompanyRepository extends Repository
{
    public function search($name = null,$price = null,$number = null, $limit = 10)
    {
        $limit=$limit??10;
        $query = new Query();
        $boolQuery = new BoolQuery();
        $fieldQuery = new Query\MatchPhrasePrefix();
        $fieldQuery->setField('name', $name);
        $boolQuery->addMust($fieldQuery);
//        if (!\is_null($name)) {
//            $fieldQuery = new Query\MatchPhrasePrefix();
//            $fieldQuery->setField('name', $name);
//            $boolQuery->addMust($fieldQuery);
//        }
//        if (!\is_null($price)) {
//            $fieldQuery = new Query\MatchPhrasePrefix();
//            $fieldQuery->setField('price', $price);
//            $boolQuery->addMust($fieldQuery);
//        }
//        if (!\is_null($number)) {
//            $fieldQuery = new Query\MatchPhrasePrefix();
//            $fieldQuery->setField('number', $number);
//            $boolQuery->addMust($fieldQuery);
//        }


        $query->setQuery($boolQuery);
        $query->setSize($limit);


        return $this->find($query,$limit);
    }
}
