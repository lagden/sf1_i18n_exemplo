<?php

/**
* home actions.
*
* @package    sfI18nSample
* @subpackage home
* @author     Thiago Lagden
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class homeActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();

        if (!$request->getParameter('sf_culture'))
        {
            if ($this->getUser()->isFirstRequest())
            {
                $culture = $request->getPreferredCulture(array('br', 'en'));
                $this->getUser()->setCulture($culture);
                $this->getUser()->isFirstRequest(false);
            }

            $this->redirect('localized_homepage');
        }

        $this->categories = Doctrine_Core::getTable('Category')->findAll($culture)->execute();
    }

    public function executeChangeLanguage(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();
        $this->getUser()->setCulture(($culture == 'br') ? 'en' : 'br');
        return $this->redirect('localized_homepage');
    }

    public function executeShowCategoria(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();
        $this->category = Doctrine_Core::getTable('Category')->findOneBySlugAndCulture($request['slug'], $culture)->fetchOne();
    }
}
