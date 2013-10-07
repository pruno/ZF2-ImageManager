<?php

namespace ImageManager\Storage\Adapter;

use ImageManager\Storage\StorageAdapterInterface;

/**
 * Class FilesystemAdapter
 * @package ImageManager\Storage\Adapter
 */
class FilesystemAdapter implements StorageAdapterInterface
{
    /**
     * @var array
     * @todo umask is never applyed
     */
    protected $options = array(
        'base_dir'          =>  './',
        'umask'             =>  null,
    );

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        if (array_key_exists('base_dir', $options) && is_string($options['base_dir'])) {
            $this->options['base_dir'] = $options['base_dir'];
        }

        if (array_key_exists('umask', $options)) {
            $this->options['umask'] = $options['umask'];
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
     * @throws \Exception
     */
    public function ensureStorage()
    {
        if (!is_dir($this->options['base_dir'])) {
            throw new \Exception("Could not stat base directory {$this->options['base_dir']}");
        }
    }

    /**
     * @return bool
     */
    public function canDeclareIdentifier()
    {
        return false;
    }

    /**
     * @param mixed $id
     * @return string
     */
    public function resolveFilepath($id)
    {
        return "{$this->options['base_dir']}/{$id}";
    }

    /**
     * @param mixed $id
     * @param $blob
     */
    public function set($id, $blob)
    {
        file_put_contents(
            $this->resolveFilepath($id),
            $blob
        );
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function has($id)
    {
        return file_exists(
            $this->resolveFilepath($id)
        );
    }

    /**
     * @param mixed $id
     * @return null|string
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            return null;
        }

        return file_get_contents(
            $this->resolveFilepath($id)
        );
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

        unlink(
            $this->resolveFilepath($id)
        );

        return true;
    }
}