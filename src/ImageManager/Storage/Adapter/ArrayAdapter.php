<?php

namespace ImageManager\Storage\Adapter;

/**
 * Class ArrayAdapter
 * @package ImageManager\Storage\Adapter
 */
class ArrayAdapter extends AbstractStorageAdapter
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @param mixed $id
     * @param string $blob
     */
    public function set($id, $blob)
    {
        $this->data[(string) $id] = $blob;
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->data);
    }

    /**
     * @param mixed $id
     * @return null|string
     */
    public function get($id)
    {
        return $this->has($id) ? $this->data[(string) $id] : null;
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function delete($id)
    {
        if (!$this->has($id)) {
            return false;
        }

        unset($this->data[(string) $id]);
        return true;
    }
}