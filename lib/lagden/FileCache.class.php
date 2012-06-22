<?php
class FileCache
{
    static public $cache;

    static public function getInstance($dir = "myFileCache")
    {
        $ds = DIRECTORY_SEPARATOR;
        if (!static::$cache instanceof sfFileCache) {
            $file_cache_dir = sfConfig::get('sf_cache_dir') . "{$ds}{$dir}";
            static::$cache = new sfFileCache(array('cache_dir'=>$file_cache_dir));
        }
        return static::$cache;
    }

    static public function setCache($name, $value, $lt=3600)
    {
        $cache = static::getInstance();
        return $cache->set($name, serialize($value), $lt);
    }

    static public function getCache($name)
    {
        $cache = static::getInstance();
        if ($cache->has($name))
        {
            $cached = $cache->get($name);
            if (!empty($cached))
            {
                return unserialize($cached);
            }
        }
        return false;
    }

    static public function cleanCache($mode = sfCache::ALL)
    {
        $cache = static::getInstance();
        return $cache->clean($mode);
    }
}
