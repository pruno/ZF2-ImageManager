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
    public function __construct(Storage $storage = null)
    {
        if ($storage) {
            $this->setStorage($storage);
        }
    }

    /**
     * @param Storage $storage
     * @param bool $preserveId
     */
    public function setStorage(Storage $storage, $preserveId = false)
    {
        if ($this->storage === $storage) {
            return;
        }

        if (!$preserveId) {
            $this->id = null;
        }

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