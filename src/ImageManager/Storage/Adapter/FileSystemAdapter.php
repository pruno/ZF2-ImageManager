<?php

namespace ImageManager\Storage\Adapter;

/**
 * Class FilesystemAdapter
 * @package ImageManager\Storage\Adapter
 */
class FilesystemAdapter extends AbstractStorageAdapter
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
     * @param string $blob
     * @return string
     */
    public function set($id, $blob)
    {
        file_put_contents(
            $this->resolveFilepath($id),
            $blob
        );

        return $id;
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