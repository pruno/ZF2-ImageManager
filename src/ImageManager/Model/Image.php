<?php

namespace ImageManager\Model;

use ImageManager\Storage\StorageAdapterInterface;

/**
 * Class Image
 * @package ImageManager\Model
 */
class Image implements ImageInterface
{
    /**
     * @var StorageAdapterInterface
     */
    protected $storage;

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $blob;

    /**
     * @param StorageAdapterInterface $storage
     */
    public function __construct(StorageAdapterInterface $storage)
    {
        $this->setStorage($storage);
    }

    /**
     * @param StorageAdapterInterface $storage
     */
    public function setStorage(StorageAdapterInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return StorageAdapterInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $blob
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
    }

    /**
     * @return string
     */
    public function getBlob()
    {
        return $this->blob;
    }
}