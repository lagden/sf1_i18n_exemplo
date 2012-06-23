<?php

/**
 * full actions.
 *
 * @package    sfI18nSample
 * @subpackage full
 * @author     Thiago Lagden
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class fullActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        // Coloques as entidades + rotas que irão aparecer na busca
        $entities = array();
        $entities[0]['entity'] = 'Product'; 
        $entities[0]['rota'] = 'produto_show';

        $entities[1]['entity'] = 'Category'; 
        $entities[1]['rota'] = 'categoria_show';

        $this->busca = Xtras::getSearchTerm('cookie_search_full_term');
        $this->pager = static::busca($request, $entities);
    }
    
    public function executeFiltro(sfWebRequest $request)
    {
        // Filtro
        $filter = new SearchFormFilter();
        $filterParams = $request->getParameter($filter->getName());
        
        // Seta cookie do termo postado no filtro
        Xtras::set($filterParams,'cookie_search_full_term');

        $this->redirect('full_busca');
    }
    
    // Busca usando Search Lucene
    static private function busca($request, $entities)
    {
        // Pega o idioma
        $culture = sfContext::getInstance()->getUser()->getCulture();

        // Pega o termo gravado no cookie
        $term = Xtras::getSearchTerm('cookie_search_full_term');

        // Limpa o cache (for debug)
        // FileCache::cleanCache();

        // Verifica se o resultado da busca está cacheado
        $cacheFile = md5("{$term}.{$culture}");
        $final = FileCache::getCache($cacheFile);

        // Constrói o resultado e grava no cache
        if(!$final)
        {
            $cc = 0;
            $final = array();
            foreach ($entities as $k => $entity)
            {
                $result = Xtras::getLuceneQueryAndPks(Doctrine_Core::getTable($entity['entity']), $term, $culture);
                if (empty($result)) unset($entities[$k]);
                else
                {
                    foreach ($result['query']->execute() as $item)
                    {
                        $final[$cc]['entity'] = $entity['entity'];
                        $final[$cc]['rota'] = $entity['rota'];
                        $final[$cc]['score'] = $result['pks'][$item->id]['score'];
                        $final[$cc]['id'] = $item->id;
                        $final[$cc]['route'] = $item->slug_route;
                        $final[$cc]['name'] = $item->name;
                        try {
                            $final[$cc]['description'] = $item->description;
                        }
                        catch (Exception $e) {
                            $final[$cc]['description'] = null;
                        }
                        $cc++;
                    }
                }
            }
            usort($final, "cmp");
            FileCache::setCache($cacheFile, $final);
        }
        $maxPerPage = 5;
        return Xtras::getZendPager($final, $request, $maxPerPage);
    }
}

function cmp($a, $b)
{
    if ($a["score"] == $b["score"]) return 0;
    return ($a["score"] > $b["score"]) ? -1 : 1;
}
