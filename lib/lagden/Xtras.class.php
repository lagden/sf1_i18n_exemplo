<?php

/**
 * Xtras class
 *
 * @package default
 * @author Thiago Lagden
 **/
class Xtras
{
    // Return sfDoctrinePager
    static public function getPager($query, $entity, $request, $maxPerPage)
    {
        $pagina = $request->getParameter('pagina',1);
        $pager = new sfDoctrinePager($entity);
        $pager->setQuery($query);
        $pager->setPage($pagina);
        $pager->setMaxPerPage($maxPerPage);
        $pager->init();
        return $pager;
    }

    // Return Zend_Paginator
    static public function getZendPager($result, $request, $maxPerPage)
    {
        ProjectConfiguration::registerZend();
        $pagina = $request->getParameter('pagina',1);
        $pager = Zend_Paginator::factory($result);
        $pager->setCurrentPageNumber($pagina);
        $pager->setItemCountPerPage($maxPerPage);
        return $pager;
    }

    // Return String
    static public function getSearchTerm($name='name_search_term', $field='q')
    {
        $term = static::get($name, array("{$field}" => ''));
        $term = isset($term[$field]) ? $term[$field] : '';
        return $term;
    }

    // Return @if true {Doctrine_Query} else {Empty Array}
    static public function getQuery($tbl, $term, $culture = null)
    {
        $q = $tbl::getListQuery();
        $alias = $q->getRootAlias();

        if($tbl->hasRelation('Translation'))
        {
            $q->leftJoin("{$alias}.Translation t")->andWhere('t.lang = ?', $culture);
            $q = SearchLucene::getLuceneQuery($tbl, $term, $culture, $q);
        }
        else
            $q = $tbl->getLuceneQuery($term, $q);
        
        return $q;
    }

    // Retorn Array - @if true {query and pks} else {empty}
    static public function getLuceneQueryAndPks($tbl, $term, $culture = null)
    {
        $q = $tbl::getListQuery();
        $alias = $q->getRootAlias();

        if($tbl->hasRelation('Translation'))
            $q->leftJoin("{$alias}.Translation t")->andWhere('t.lang = ?', $culture);
        else
            $culture = null;

        return SearchLucene::getLuceneQueryAndPks($tbl, $term, $culture, $q);
    }

    // Get
    static public function get($name='default_data', $default=array())
    {
        return sfContext::getInstance()->getUser()->getAttribute($name, $default);
    }

    // Set
    static public function set($filters,$name='default_data')
    {
        return sfContext::getInstance()->getUser()->setAttribute($name, $filters);
    }
}