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
        $this->product = Doctrine_Core::getTable('Product')->findOneBySlugAndCulture($request['slug'], $culture)->fetchOne();
    }
}
