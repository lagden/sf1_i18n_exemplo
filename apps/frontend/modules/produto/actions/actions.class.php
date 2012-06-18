<?php

/**
* produto actions.
*
* @package    sfI18nSample
* @subpackage produto
* @author     Thiago Lagden
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class produtoActions extends sfActions
{
    public function executeShow(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();
        $this->product = Doctrine_Core::getTable('Product')->findOneByRouteAndCulture($request['route'], $culture)->fetchOne();
    }

    public function executeSearch(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();
        $tbl = Doctrine_Core::getTable('Product');
        
        $r = ($q = $request->getParameter('q',false)) ? $tbl->getForLuceneQuery($q, $culture) : false;
        $r = ($r) ? $tbl->findByCulture($culture, $r)->execute()->toArray() : ['none'];
        $this->getResponse()->setContentType('application/json');
        return $this->renderText(json_encode($r));
    }
}
