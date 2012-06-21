<?php
class SearchFormFilter extends sfFormFilter
{
    public function configure()
    {
        $this->widgetSchema['q'] = new sfWidgetFormInput(array('label' => 'Busca',), array('placeholder'=>'Buscar no site','type'=>'search','title'=>'Busca',));
        $this->validatorSchema['q'] = new sfValidatorPass;
        $this->widgetSchema->setNameFormat('searchfilter[%s]');
    }
}
