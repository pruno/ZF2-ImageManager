<?php

namespace ImageManager\Model;

use ImageManager\Storage\Storage;

/**
 * Class Image
 * @package ImageManager\Model
 */
class Image implements ImageInterface
{
    /**
     * @var Storage
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
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->setStorage($storage);
    }

    /**
     * @param Storage $storage
     */
    public function setStorage(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return Storage
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

    public function save()
    {
        $this->getStorage()->saveImage($this);
    }

    /**
     * @return bool
     */
    public function delete()
    {
        return $this->getStorage()->deleteImage($this);
    }
}