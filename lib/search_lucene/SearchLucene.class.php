<?php
class SearchLucene extends Doctrine_Template
{
    protected $_options = array('fields' => array(),);

    public function setTableDefinition()
    {
        if (empty($this->_options['fields'])) throw new Doctrine_Table_Exception("SearchLucene: The option 'fields' must be defined");
        $this->addListener(new SearchLuceneListener($this->_options));
    }

    public function getLuceneQueryTableProxy($term, $culture = null, Doctrine_Query $q = null)
    {
        return static::getLuceneQuery($this->getTable(), $term, $culture, $q);
    }

    static public function getLuceneQuery(Doctrine_Table $tbl, $term, $culture = null, Doctrine_Query $q = null)
    {
        $r = static::getLuceneQueryAndPks($tbl, $term, $culture, $q);
        return isset($r['query']) ? $r['query'] : array();
    }

    static public function getLuceneQueryAndPks(Doctrine_Table $tbl, $term, $culture = null, Doctrine_Query $q = null)
    {
        if(null === $q) $q = $tbl->createQuery('a');
        $alias = $q->getRootAlias();

        $pks = static::getLucenePks($tbl, $term, $culture);

        if (empty($pks)) return array();
        else $q->andWhereIn("{$alias}.id", array_keys($pks));

        return array('query'=>$q,'pks'=>$pks);
    }

    static public function getLucenePks(Doctrine_Table $tbl, $term, $culture = null)
    {
        $index = SearchLucenePlugin::getLuceneIndex($tbl->getTableName(),$culture);
        $hits = $index->find($term);
        $pks = array();
        foreach ($hits as $hit) $pks[$hit->pk]['score'] = $hit->score;
        return $pks;
    }
}
