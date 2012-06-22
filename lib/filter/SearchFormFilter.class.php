<?php
class SearchFormFilter extends sfFormFilter
{
    public function configure()
    {
        $this->widgetSchema['q'] = new sfWidgetFormInput(array('label' => 'Busca',), array('type'=>'search',));
        $this->validatorSchema['q'] = new sfValidatorPass;
        $this->widgetSchema->setNameFormat('searchfilter[%s]');
    }
}
