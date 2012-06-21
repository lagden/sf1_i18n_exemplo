<?php
class SearchLuceneListener extends Doctrine_Record_Listener
{
    protected $_options = array();

    public function __construct(array $options)
    {
        $this->_options = $options;
    }

    public function postUpdate(Doctrine_Event $event)
    {
        $record = $event->getInvoker();
        SearchLucenePlugin::updateLuceneIndex($record,$this->_options['fields']);
    }

    public function postInsert(Doctrine_Event $event)
    {
        $record = $event->getInvoker();
        SearchLucenePlugin::updateLuceneIndex($record,$this->_options['fields']);
    }

    public function postDelete(Doctrine_Event $event)
    {
        $record = $event->getInvoker();
        SearchLucenePlugin::deleteLuceneIndex($record,$this->_options['fields']);
    }
}
