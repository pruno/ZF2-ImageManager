<?php

namespace ImageManager\Model;

use ImageManager\Storage\Storage;

/**
 * Class ImageInterface
 * @package ImageManager\Model
 */
interface ImageInterface
{
    /**
     * @param $id
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $blob
     */
    public function setBlob($blob);

    /**
     * @return string
     */
    public function getBlob();

    /**
     * @param Storage $storage
     * @param bool $preserveId
     */
    public function setStorage(Storage $storage, $preserveId = null);

    /**
     * @return Storage
     */
    public function getStorage();
}