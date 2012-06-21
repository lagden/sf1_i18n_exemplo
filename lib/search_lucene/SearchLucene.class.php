<?php
class SearchLucene extends Doctrine_Template
{
    protected $_options = array(
        'fields' => array(),
                                );

    public function setTableDefinition()
    {
        $this->addListener(new SearchLuceneListener($this->_options));
    }

    // for tables without translation(i18n) configured
    public function getLuceneQueryTableProxy($search, Doctrine_Query $q = null)
    {
        return static::getLuceneQuery($search,$this->getTable(),null,$q);
    }

    // Helper for tables with i18n configured
    static public function getLuceneQuery($search, Doctrine_Table $tbl, $culture = null, Doctrine_Query $q = null)
    {
        if(null === $q) $q = $tbl->createQuery('a');
        $alias = $q->getRootAlias();

        $index = SearchLucenePlugin::getLuceneIndex($tbl->getTableName(),$culture);
        $hits = $index->find($search);
        $pks = array();

        foreach ($hits as $hit) $pks[] = $hit->pk;

        if (empty($pks)) return array();

        $q->whereIn("{$alias}.id", $pks);
        return $q;
    }
}
