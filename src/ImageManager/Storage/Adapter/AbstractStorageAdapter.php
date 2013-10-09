<?php

namespace ImageManager\Storage\Adapter;

/**
 * Class AbstractStorageAdapter
 * @package ImageManager\Storage\Adapter
 */
abstract class AbstractStorageAdapter
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        foreach ($this->options as $key => &$val) {
            if (array_key_exists($key, $options)) {
                $val = $options[$key];
            }
        }
    }

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
        return $this->canSave();
    }

    /**
     * @return bool
     */
    public function canSave()
    {
        return true;
    }
}