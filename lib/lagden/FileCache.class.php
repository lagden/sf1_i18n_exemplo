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
        $file_cache = static::getInstance();
        return $file_cache->set($name, serialize($value), $lt);
    }

    static public function getCache($name)
    {
        $file_cache = static::getInstance();
        if ($has = $file_cache->has($name))
        {
            $cached = $file_cache->get($name);
            if (!empty($cached))
            {
                return unserialize($cached);
            }
        }
        return $has;
    }
}
