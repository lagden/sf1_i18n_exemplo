<?php

/**
 * Xtras class
 *
 * @package default
 * @author Thiago Lagden
 **/
class Xtras
{
    // sfDoctrinePager
    static public function getPager($query, $request, $maxPerPage)
    {
        $pagina = $request->getParameter('pagina',1);
        $pager = new sfDoctrinePager('Product');
        $pager->setQuery($query);
        $pager->setPage($pagina);
        $pager->setMaxPerPage($maxPerPage);
        $pager->init();
        return $pager;
    }

    static public function getSearchTerm($field='q', $cookie = 'cookie_search_term')
    {
        $term = static::get('cookie_search_term', array("{$field}" => ''));
        $term = isset($term[$field]) ? $term[$field] : '';
        return $term;
    }

    static public function getQuery($tbl, $term, $culture = null)
    {
        $q = $tbl::getListQuery();
        $alias = $q->getRootAlias();

        // Com i18n
        if($tbl->hasRelation('Translation'))
        {
            $q = SearchLucene::getLuceneQuery($tbl, $term, $culture, $q);
            $q->leftJoin("{$alias}.Translation t")
              ->andWhere('t.lang = ?', $culture);
        }
        // Sem i18n
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