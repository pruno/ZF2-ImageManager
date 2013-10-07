<?php

namespace ImageManager\Storage\Adapter;

use ImageManager\Storage\StorageAdapterInterface;

/**
 * Class ArrayAdapter
 * @package ImageManager\Storage\Adapter
 */
class ArrayAdapter implements StorageAdapterInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @return void
     */
    public function connect()
    {
        // Nothing to do
    }

    /**
     * @return void
     */
    public function disconnect()
    {
        // Nothing to do
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return true;
    }

    /**
     * @return void
     */
    public function ensureStorage()
    {
        // Nothing to do
    }

    /**
     * @return bool
     */
    public function canDeclareIdentifier()
    {
        return true;
    }

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