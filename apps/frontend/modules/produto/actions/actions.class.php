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
        // @if tem i18n configurado no template do modelo da tabela, então use o método estático: SearchLucene::getLuceneQuery
        // @else $tbl->getLuceneQuery

        $culture = $this->getUser()->getCulture();
        $tbl = Doctrine_Core::getTable('Product');

        $r = ($q = $request->getParameter('q',false)) ? SearchLucene::getLuceneQuery($tbl, $q, $culture) : false;
        $r = ($r) ? $tbl->findByCulture($culture, $r)->execute()->toArray() : ['none'];
        
        $this->getResponse()->setContentType('application/json');
        return $this->renderText(json_encode($r));
    }

    public function executeFixtures(sfWebRequest $request)
    {
        // Fill products
        for ($xxx = 1; $xxx < 10; $xxx++)
        {
            $hash = md5(time() . mt_rand());
            $prod = new Product();

            $prod->category_id = 1;
            $prod->route = "DVD do Homem Aranha | {$hash}";
            $prod->is_active = 1;

            $prod->Translation['pt']->name = "DVD do Homem Aranha {$xxx} | {$hash}";
            $prod->Translation['pt']->description  = "Essa é uma descrição em pt {$xxx} | {$hash}";
            $prod->Translation['pt']->price  = 29.23 + $xxx;

            $prod->Translation['en']->name = "Spider-man DVD {$xxx} | {$hash}";
            $prod->Translation['en']->description  = "This is a description in en {$xxx} | {$hash}";
            $prod->Translation['en']->price  = 10.23 + $xxx;
            $prod->save();
        }
        $this->getResponse()->setContentType('text/plain');
        return $this->renderText('filled products');
    }
}
