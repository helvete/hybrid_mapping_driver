<?php

namespace Utils\Doctrine;

class NullCache extends \Doctrine\Common\Cache\CacheProvider
{
    private $namespace = 'null-cache-impl';

    protected function doFetch($id)
    {
        return false;
    }

    protected function doContains($id)
    {
        return false;
    }

    protected function doSave($id, $data, $lifeTime = 0)
    {
        return true;
    }

    protected function doDelete($id)
    {
        return true;
    }

    protected function doFlush()
    {
        return true;
    }

    protected function doGetStats()
    {
        return null;
    }
}
