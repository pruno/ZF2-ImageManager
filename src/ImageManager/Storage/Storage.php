<?php

namespace ImageManager\Storage;

use ImageManager\Model\ImageInterface;

/**
 * Class Storage
 * @package ImageManager\Storage
 */
class Storage
{
    /**
     * @var StorageAdapterInterface
     */
    protected $adapter;

    /**
     * @param StorageAdapterInterface $adpter
     */
    public function __construct(StorageAdapterInterface $adpter)
    {
        $this->adapter = $adpter;
    }

    /**
     * @return StorageAdapterInterface
     */
    public function getAdapter()
    {
        if (!$this->adapter->isConnected()) {
            $this->adapter->connect();
        }

        return $this->adapter;
    }

    /**
     * @param ImageInterface $image
     * @return void
     * @throws \InvalidArgumentException
     */
    public function saveImage(ImageInterface $image)
    {
        $id = $image->getId();

        if (!$id && !$this->getAdapter()->canDeclareIdentifier()) {
            throw new \InvalidArgumentException("Image need an id in order to be saved");
        }

        $this->getAdapter()->set(
            $id,
            $image->getBlob()
        );
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasImage($id)
    {
        return $this->getAdapter()->has($id);
    }

    /**
     * @param $id
     * @return ImageInterface
     */
    public function loadImage($id)
    {
        return $this->getAdapter()->get($id);
    }

    /**
     * @param ImageInterface $image
     * @return bool
     */
    public function deleteImage(ImageInterface $image)
    {
        return $this->getAdapter()->delete(
            $image->getId()
        );
    }
}