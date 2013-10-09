<?php

namespace ImageManager\Storage\Adapter;

/**
 * Class HttpAdapter
 * @package ImageManager\Storage\Adapter
 */
class HttpAdapter extends AbstractStorageAdapter
{
    /**
     * @var array
     */
    protected $options = array(
        'cache_results' => true,
    );

    /**
     * @var array
     */
    protected $cache = array();

    /**
     * @return bool
     */
    public function canSave()
    {
        return false;
    }

    /**
     * @param mixed $id
     * @param string $blob
     * @throws \Exception
     */
    public function set($id, $blob)
    {
        throw new \Exception("HttpAdapter can't perform save");
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function has($id)
    {
        return !!$this->get($id);
    }

    /**
     * @param mixed $id
     * @return null|string
     */
    public function get($id)
    {
        if (array_key_exists($id, $this->cache)) {
            return $this->cache[$id];
        }

        $blob = file_get_contents($id);
        if (!$blob) {
            $blob = null;
        }

        return $this->cache[$id] = $blob;
    }

    /**
     * @param mixed $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        throw new \Exception("HttpAdapter can't perform save");
    }
}