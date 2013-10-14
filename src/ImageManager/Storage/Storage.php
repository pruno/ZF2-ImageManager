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
     * @var ImageInterface
     */
    protected $imagePrototype;

    /**
     * @param StorageAdapterInterface $adapter
     * @param ImageInterface $imagePrototype
     */
    public function __construct(StorageAdapterInterface $adapter, ImageInterface $imagePrototype = null)
    {
        $this->adapter = $adapter;
        if ($imagePrototype) {
            $this->setPrototype($imagePrototype);
        }
    }

    /**
     * @return ImageInterface
     */
    public function create()
    {
        return clone $this->imagePrototype;
    }

    /**
     * @param ImageInterface $imagePrototype
     */
    public function setPrototype(ImageInterface $imagePrototype)
    {
        $this->imagePrototype = $imagePrototype;
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
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    public function saveImage(ImageInterface $image)
    {
        if (!$this->getAdapter()->canSave()) {
            throw new \Exception("Adapter ".get_class($this->getAdapter())." can't perform save.");
        }

        $id = $image->getId();

        if (!$id && !$this->getAdapter()->canDeclareIdentifier()) {
            throw new \InvalidArgumentException("Image need an id in order to be saved");
        }

        $id = $this->getAdapter()->set(
            $id,
            $image->getBlob()
        );

        $image->setId($id);
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
     * @return ImageInterface|null
     */
    public function loadImage($id)
    {
        $blob = $this->getAdapter()->get($id);
        if (!$blob) {
            return null;
        }

        $image = $this->create();
        $image->setId($id);
        $image->setBlob($blob);

        return $image;
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