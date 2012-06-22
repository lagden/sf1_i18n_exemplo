<?php

/**
 * Xtras class
 *
 * @package default
 * @author Thiago Lagden
 **/
class Xtras
{
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

    static public function getSearchTerm($cookie='cookie_search_term', $field='q')
    {
        $term = static::get($cookie, array("{$field}" => ''));
        $term = isset($term[$field]) ? $term[$field] : '';
        return $term;
    }

    // Retorna um Array vazio ou um Doctrine_Query
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
        {
            $q = $tbl->getLuceneQuery($term, $q);
        }
        return $q;
    }

    static public function get($cookie='cookie_site_default')
    {
        return sfContext::getInstance()->getUser()->getAttribute($cookie,array());
    }

    static public function set($filters,$cookie='cookie_site_default')
    {
        return sfContext::getInstance()->getUser()->setAttribute($cookie, $filters);
    }
}