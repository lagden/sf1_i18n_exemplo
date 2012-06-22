<?php 
class fullComponents extends sfComponents
{
    public function executeFiltro(sfWebRequest $request)
    {
        $filters = Xtras::get('cookie_search_full_term');
        $this->route = 'full_busca_filtro';
        $this->form = new SearchFormFilter($filters);
    }
}
