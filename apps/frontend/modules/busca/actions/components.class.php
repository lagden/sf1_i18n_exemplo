<?php 
class buscaComponents extends sfComponents
{
    public function executeFiltro(sfWebRequest $request)
    {
        $filters = Xtras::get('cookie_search_term');
        $this->route = 'busca_filtro';
        $this->form = new SearchFormFilter($filters);
    }
}
