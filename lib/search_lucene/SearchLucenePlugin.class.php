<?php
class SearchLucenePlugin
{
    static public function updateLuceneIndex($record, $fields)
    {
        $culture = static::i18n($record);
        $index = static::getLuceneIndex($record->getTable()->getTableName(),$culture);

        // remove existing entries
        foreach ($index->find("pk:".$record->id) as $hit)
        {
            $index->delete($hit->id);
        }

        $doc = new Zend_Search_Lucene_Document();

        // store primary key to identify it in the search results
        $doc->addField(Zend_Search_Lucene_Field::Keyword("pk", $record->id));

        // index fields
        foreach ($fields as $field)
        {
            $doc->addField(Zend_Search_Lucene_Field::UnStored($field, $record->$field, 'utf-8'));
        }

        // add to the index
        $index->addDocument($doc);
        $index->commit();
        $index->optimize();
    }

    public function deleteLuceneIndex($record)
    {
        $culture = static::i18n($record);
        $index = static::getLuceneIndex($record->getTable()->getTableName(),$culture);
        foreach ($index->find("pk:".$record->id) as $hit)
        {
            $index->delete($hit->id);
        }
        $index->optimize();
    }
    
    static public function getLuceneIndex($name, $culture=null)
    {
        ProjectConfiguration::registerZend();
        if (file_exists($index = self::getLuceneIndexFile($name, $culture))) return Zend_Search_Lucene::open($index);
        return Zend_Search_Lucene::create($index);
    }

    static public function getLuceneIndexFile($name, $culture=null)
    {
        $ds = DIRECTORY_SEPARATOR;
        $name = str_replace('_translation', '', $name);
        return sfConfig::get('sf_data_dir') . "{$ds}lucene{$ds}{$name}." . sfConfig::get('sf_environment') . (($culture) ? ".{$culture}" : "") . ".index";
    }

    // return culture from record
    static private function i18n($record)
    {
        $lang = $record->getTable()->hasField('lang');
        return ($lang) ? $record->$lang : null;
    }
}
