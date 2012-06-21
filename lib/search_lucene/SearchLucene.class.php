<?php
class SearchLucene extends Doctrine_Template
{
    protected $_options = array('fields' => array(),);

    public function setTableDefinition()
    {
        if (empty($this->_options['fields'])) throw new Doctrine_Table_Exception("The option 'fields' can not be null"); 
        $this->addListener(new SearchLuceneListener($this->_options));
    }

    public function getLuceneQueryTableProxy($term, $culture = null, Doctrine_Query $q = null)
    {
        return static::getLuceneQuery($this->getTable(), $term, $culture, $q);
    }

    static public function getLuceneQuery(Doctrine_Table $tbl, $term, $culture = null, Doctrine_Query $q = null)
    {
        if(null === $q) $q = $tbl->createQuery('a');
        $alias = $q->getRootAlias();

        $index = SearchLucenePlugin::getLuceneIndex($tbl->getTableName(),$culture);
        $hits = $index->find($term);
        $pks = array();

        foreach ($hits as $hit) $pks[] = $hit->pk;

        if (empty($pks)) $q->andWhere("{$alias}.id = ?", 'empty_search_zend_lucene'); // return array();
        else $q->andWhereIn("{$alias}.id", $pks);

        return $q;
    }
}
