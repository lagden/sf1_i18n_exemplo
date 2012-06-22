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
    // Seta o idioma se não existir
    public function executeIndex(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();

        if (!$request->getParameter('sf_culture'))
        {
            if ($this->getUser()->isFirstRequest())
            {
                $culture = $request->getPreferredCulture(array('pt', 'en'));
                $this->getUser()->setCulture($culture);
                $this->getUser()->isFirstRequest(false);
            }

            $this->redirect('localized_homepage');
        }

        $this->categories = Doctrine_Core::getTable('Category')->getByCulture($culture)->execute();
    }

    // Troca o idioma
    public function executeChangeLanguage(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();
        $lang = ($culture == 'pt') ? 'en' : 'pt';
        $this->getUser()->setCulture($lang);

        // Redireciona para a mesma url
        $path = base64_decode($request['path']);
        $path = explode("/", $path);
        $path[1] = $lang;
        $path = $_SERVER['SCRIPT_NAME'] . join("/", $path);

        return $this->redirect($path);
    }

    // Mostra a Categoria e seus produtos
    public function executeShowCategoria(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();
        $this->category = Doctrine_Core::getTable('Category')->getOneByRouteAndCulture($request['route'], $culture)->fetchOne();
    }
}
