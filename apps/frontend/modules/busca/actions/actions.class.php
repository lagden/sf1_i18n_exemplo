<?php

/**
 * busca actions.
 *
 * @package    sfI18nSample
 * @subpackage busca
 * @author     Thiago Lagden
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class buscaActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $entity = $request->getParameter('entity','Product');
        
        $this->busca = Xtras::getSearchTerm();
        $this->pager = static::busca($request, $entity);
    }
    
    public function executeFiltro(sfWebRequest $request)
    {
        // Filtro
        $filter = new SearchFormFilter();
        $filterParams = $request->getParameter($filter->getName());
        
        // Seta cookie do termo postado no filtro
        Xtras::set($filterParams,'cookie_search_term');

        $this->redirect('busca');
    }
    
    // Busca usando Search Lucene
    static private function busca($request, $entity)
    {
        // Pega o idioma
        $culture = sfContext::getInstance()->getUser()->getCulture();

        // Pega o termo gravado no cookie
        $term = Xtras::getSearchTerm();

        // Monta query
        $query = Xtras::getQuery(Doctrine_Core::getTable($entity), $term, $culture);
        if(empty($query)) return $query;
        else
        {
            // Total de itens por página
            $maxPerPage = 5;

            // Retorna o objeto sfDoctrinePager
            return Xtras::getPager($query, $entity, $request, $maxPerPage);
        }
    }
}